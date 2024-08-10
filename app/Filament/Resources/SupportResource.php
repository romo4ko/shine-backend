<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupportResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\Support\Support;

class SupportResource extends Resource
{
    protected static ?string $model = Support::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-oval-left-ellipsis';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Поддержка';

    protected static ?string $modeLabel = 'Обращения';

    protected static ?string $pluralModelLabel = 'Обращения';

    protected static ?string $breadcrumb = 'Обращения';

    protected static ?string $label = 'Обращение';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('text')
                    ->label('Текст обращения')
                    ->disabled(),
                Forms\Components\Select::make('status')
                    ->label('Статус')
                    ->options(Support::STATUSES),
                Forms\Components\Textarea::make('answer')
                    ->formatStateUsing(function (Support $record) {
                        if (is_null($record->user)) {
                            return $record->answer ?? $record->email.config('messages.template.support.answer');
                        }

                        return $record->answer ?? $record->user->properties->name.config('messages.template.support.answer');
                    })
                    ->label('Текст ответа')
                    ->disabled(function (Support $record) {
                        return $record->status !== Support::NEW;
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('text')
                    ->label('Текст обращения')
                    ->limit(50),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Пользователь')
                    ->default(fn ($record) => ! is_null($record->user) ? $record->user->email : $record->email)
                    ->url(fn ($record) => ! is_null($record->user) ? "/admin/users/{$record->user->id}" : '')
                    ->icon('heroicon-o-x-circle')
                    ->iconColor('warning'),
                Tables\Columns\TextColumn::make('statusName')
                    ->label('Статус'),
                Tables\Columns\TextColumn::make('created_at')
                    ->date('d.m.Y H:i')
                    ->label('Создано'),
                Tables\Columns\TextColumn::make('processed_at')
                    ->label('Обработано')
                    ->date('d.m.Y H:i')
                    ->placeholder('-'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Filter::make('new')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->orWhere('status', Support::NEW))
                    ->label('Новые')
                    ->default(),
                Filter::make('in_progress')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->orWhere('status', Support::IN_PROGRESS))
                    ->label('В обработке'),
                Filter::make('done')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->orWhere('status', Support::DONE))
                    ->label('Обработанные'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Ответить'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSupports::route('/'),
            'edit' => Pages\EditSupport::route('/{record}/edit'),
        ];
    }
}
