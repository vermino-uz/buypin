<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Game;
use App\Models\PromoCode;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Jami foydalanuvchilar', User::count() . ' ta'),
            Stat::make('Jami o\'yinlar', Game::count() . ' ta'),
            Stat::make('Jami promo kodlar', PromoCode::count() . ' ta'),
        ];
    }
}
