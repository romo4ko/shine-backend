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
                            $statuses[User::confirmation]['value'] => 'gray',
                            $statuses[User::moderation]['value'] => 'warning',
                            $statuses[User::published]['value'] => 'success',
                            $statuses[User::blocked]['value'] => 'danger',
                            $statuses[User::rejected]['value'] => 'danger',
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
