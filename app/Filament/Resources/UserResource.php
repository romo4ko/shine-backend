<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\Users\Models\User;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Пользователи';

    protected static ?string $modeLabel = 'Пользователи';

    protected static ?string $pluralModelLabel = 'Пользователи';

    protected static ?string $breadcrumb = 'Пользователи';

    protected static ?string $label = 'Пользователя';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        $statuses = config('properties.user_statuses');

        return $form
            ->schema([
                Forms\Components\TextInput::make('email')->label('Почта')
                    ->disabled(),
                Forms\Components\Select::make('status')
                    ->label('status')
                    ->options([
                        User::confirmation => $statuses[User::confirmation]['value'],
                        User::moderation => $statuses[User::moderation]['value'],
                        User::published => $statuses[User::published]['value'],
                        User::blocked => $statuses[User::blocked]['value'],
                        User::rejected => $statuses[User::rejected]['value'],
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        $statuses = config('properties.user_statuses');

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('properties.name')
                    ->label('Имя')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Почта')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->date('d.m.Y H:i')
                    ->label('Зарегистрирован'),
                Tables\Columns\TextColumn::make('statusName')
                    ->default('Подтверждение почты')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        $statuses[User::confirmation]['value'] => 'gray',
                        $statuses[User::moderation]['value'] => 'warning',
                        $statuses[User::published]['value'] => 'success',
                        $statuses[User::blocked]['value'] => 'danger',
                        $statuses[User::rejected]['value'] => 'danger',
                    })
                    ->label('Статус'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Filter::make('moderation')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->orWhere('status', User::moderation))
                    ->label('На модерации')
                    ->default(),
                Filter::make('published')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->orWhere('status', User::published))
                    ->label('Опубликован'),
                Filter::make('blocked')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->orWhere('status', User::blocked))
                    ->label('Заблокирован'),
                Filter::make('confirmation')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->orWhere('status', User::confirmation))
                    ->label('Подтверждение почты'),
                Filter::make('rejected')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->orWhere('status', User::rejected))
                    ->label('Отклонён модерацией'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListUsers::route('/'),
            //            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
