<?php

namespace App\Filament\Resources\EnviromentResource\Pages;

use App\Filament\Resources\PricesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEnviroments extends ListRecords
{
    protected static string $resource = PricesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
