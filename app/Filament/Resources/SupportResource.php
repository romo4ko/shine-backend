<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupportResource\Pages;
use App\Filament\Resources\SupportResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Support\Support;

class SupportResource extends Resource
{
    protected static ?string $model = Support::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-oval-left-ellipsis';

    protected static ?string $navigationLabel = 'Поддержка';

    protected static ?string $modeLabel = 'Обращения';

    protected static ?string $pluralModelLabel = 'Обращения';

    protected static ?string $breadcrumb = 'Обращения';

    protected static ?string $label = 'Обращение';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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
                      ->label('Пользователь'),
                  Tables\Columns\TextColumn::make('statusName')
                      ->label('Статус'),
                  Tables\Columns\TextColumn::make('created_at')
                      ->date('d.m.Y H:i')
                      ->label('Создано'),
            ])
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
                Tables\Actions\EditAction::make(),
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
