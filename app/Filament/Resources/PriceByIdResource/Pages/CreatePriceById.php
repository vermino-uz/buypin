<?php

namespace App\Filament\Resources\PriceByIdResource\Pages;

use App\Filament\Resources\PriceByIdResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePriceById extends CreateRecord
{
    protected static string $resource = PriceByIdResource::class;
}
