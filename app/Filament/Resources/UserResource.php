<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use Filament\Forms;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Modules\Users\Models\User;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Пользователи';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('email')->label('Почта')
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),
                Forms\Components\TextInput::make('properties.name')->label('Имя')
                    ->required(),
                Forms\Components\Checkbox::make('email_verified_at')->label('Почта подтверждена'),
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
                    ->label('Статус')
                    ->searchable(),
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
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
