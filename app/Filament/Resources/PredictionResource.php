<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PredictionResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Predictions\Prediction;
use Modules\Properties\Property;

class PredictionResource extends Resource
{
    protected static ?string $model = Prediction::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationLabel = 'Предсказания';

    protected static ?string $modeLabel = 'Предсказания';

    protected static ?string $pluralModelLabel = 'Предсказания';

    protected static ?string $breadcrumb = 'Предсказания';

    protected static ?string $label = 'Предсказание';

    public static function form(Form $form): Form
    {
        $property = new Property();

        return $form
            ->schema([
                Forms\Components\Textarea::make('text')
                    ->label('Текст предсказания')
                    ->required(),
                Forms\Components\Select::make('type_id')
                    ->label('Тип предсказания')
                    ->options([
                        $property->getId('prediction_types', 'funny') => 'Грубые и смешные',
                        $property->getId('prediction_types', 'needful') => 'Нежные и нужные',
                        $property->getId('prediction_types', 'mixed') => 'Смешанные',
                    ]),
                Forms\Components\Select::make('gender_id')
                    ->label('Целевой пол')
                    ->options([
                        $property->getId('gender', 'male') => 'Мужской',
                        $property->getId('gender', 'female') => 'Женский',
                    ]),
                Forms\Components\Select::make('sign_id')
                    ->label('Целевой знак зодиака')
                    ->options([
                        $property->getId('zodiac', 'aries') => 'Овен',
                        $property->getId('zodiac', 'taurus') => 'Телец',
                        $property->getId('zodiac', 'gemini') => 'Близнецы',
                        $property->getId('zodiac', 'cancer') => 'Рак',
                        $property->getId('zodiac', 'leo') => 'Лев',
                        $property->getId('zodiac', 'virgo') => 'Дева',
                        $property->getId('zodiac', 'libra') => 'Весы',
                        $property->getId('zodiac', 'scorpio') => 'Скорпион',
                        $property->getId('zodiac', 'sagittarius') => 'Стрелец',
                        $property->getId('zodiac', 'capricorn') => 'Козерог',
                        $property->getId('zodiac', 'aquarius') => 'Водолей',
                        $property->getId('zodiac', 'pisces') => 'Рыбы',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('text')
                    ->label('Текст предсказания')
                    ->limit(50),
                  Tables\Columns\TextColumn::make('type.value')
                      ->label('Тип'),
                  Tables\Columns\TextColumn::make('gender.value')
                      ->label('Пол'),
                  Tables\Columns\TextColumn::make('sign.value')
                      ->label('Знак зодиака'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создано')
                    ->date('d.m.Y H:i'),
            ])
            ->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListPredictions::route('/'),
            'create' => Pages\CreatePrediction::route('/create'),
            'edit' => Pages\EditPrediction::route('/{record}/edit'),
        ];
    }
}
