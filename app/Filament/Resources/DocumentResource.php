<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Documents\Document;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?int $navigationSort = 10;

    protected static ?string $navigationLabel = 'Документы';

    protected static ?string $modeLabel = 'Документы';

    protected static ?string $pluralModelLabel = 'Документы';

    protected static ?string $breadcrumb = 'Документы';

    protected static ?string $label = 'Документ';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('text')
                    ->label('Текст')
                    ->rows(15)
                    ->cols(20)
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Название документа')
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->label('Код документа')
                    ->disabled(fn (Document $document): bool => $document->slug == 'policy' || $document->slug == 'agreement')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Название документа'),
                Tables\Columns\TextColumn::make('url')
                    ->url(fn (Document $document): string => route('document.show', ['slug' => $document->slug]))
                    ->openUrlInNewTab()
                    ->default(fn (Document $document): string => implode('/', [env('APP_URL'), 'document', $document->slug]))
                    ->label('Ссылка'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создан')
                    ->date('d.m.Y H:i'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Изменён')
                    ->date('d.m.Y H:i'),
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
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
