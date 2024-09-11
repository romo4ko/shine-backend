<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnviromentResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Premium\Models\Price;

class PricesResource extends Resource
{
    protected static ?string $model = Price::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?int $navigationSort = 100;

    protected static ?string $navigationLabel = 'Тарифы';

    protected static ?string $modeLabel = 'Тарифы';

    protected static ?string $pluralModelLabel = 'Тарифы';

    protected static ?string $breadcrumb = 'Тарифы';

    protected static ?string $label = 'Тариф';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Тариф')
                    ->disabled(),
                Forms\Components\TextInput::make('price')
                    ->label('Цена')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Название'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Цена'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListEnviroments::route('/'),
            'edit' => Pages\EditEnviroment::route('/{record}/edit'),
        ];
    }
}
