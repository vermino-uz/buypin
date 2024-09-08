<?php

namespace App\Filament\Resources\SubTariffResource\Pages;

use App\Filament\Resources\SubTariffResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubTariff extends EditRecord
{
    protected static string $resource = SubTariffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
