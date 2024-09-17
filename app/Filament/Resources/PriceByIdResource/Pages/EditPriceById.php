<?php

namespace App\Filament\Resources\PriceByIdResource\Pages;

use App\Filament\Resources\PriceByIdResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPriceById extends EditRecord
{
    protected static string $resource = PriceByIdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
