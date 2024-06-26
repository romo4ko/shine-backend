<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Infolists;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Modules\Users\Models\User;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        $statuses = config('properties.user_statuses');

        return $infolist
            ->schema([
                Section::make([
                    Infolists\Components\TextEntry::make('properties.name')->label('Имя'),
                    Infolists\Components\TextEntry::make('email')->label('Почта'),
                    Infolists\Components\TextEntry::make('properties.birthdate')
                        ->label('Дата рождения')
                        ->date('d.m.Y'),
                    Infolists\Components\TextEntry::make('statusName')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            $statuses[User::CONFIRMATION]['value'] => 'gray',
                            $statuses[User::MODERATION]['value'] => 'warning',
                            $statuses[User::PUBLISHED]['value'] => 'success',
                            $statuses[User::BLOCKED]['value'] => 'danger',
                            $statuses[User::REJECTED]['value'] => 'danger',
                        })
                        ->label('Статус'),
                ])->columns(3),
                Infolists\Components\TextEntry::make('properties.text')->label('Текст анкеты'),
                Section::make([
                    Infolists\Components\ImageEntry::make('images.*.path')
                        ->stacked()
                        ->size(300)
                        ->label('Изображения'),
                ])->columns(1),
            ]);
    }
}
