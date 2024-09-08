<?php

namespace App\Filament\Resources\SubTariffResource\Pages;

use App\Filament\Resources\SubTariffResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubTariffs extends ListRecords
{
    protected static string $resource = SubTariffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
