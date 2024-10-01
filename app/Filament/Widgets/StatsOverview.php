<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Facades\DB;
use App\Models\BotUser;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class StatsOverview extends BaseWidget
{
    protected static bool $isLazy = true;
    protected static ?string $pollingInterval = '30s';
    protected function getStats(): array
    {
        $stats = [
            Stat::make("Jami foydalanuvchilar soni", BotUser::count() . ' ta')
                ->color("success")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->description("Foydanaluvchilar haftalik o'sish darajasi")
                ->chart($this->getUsersPerDay()['usersPerDay']),
            Stat::make("Jami promo kodlar soni", \App\Models\PromoCode::count() . ' ta')
                ->color("primary")
                ->descriptionIcon('heroicon-m-ticket')
                ->description("Barcha promo kodlar soni"),
            Stat::make("Jami o'yinlar soni", \App\Models\Game::count() . ' ta')
                ->color("warning")
                ->descriptionIcon('heroicon-m-puzzle-piece')
                ->description("Barcha o'yinlar soni"),
        Stat::make("Jami so'rovlar soni", \App\Models\Request::count() . ' ta')
            ->color("info")
            ->descriptionIcon('heroicon-m-arrow-path')
                ->description("Barcha buyurtmalar soni"),
        Stat::make("Jami foydalanuvchilar balansi", function () {
            return number_format(BotUser::sum('balance'), 0, '.', ' ') . ' $';
        })
            ->color("success")
            ->descriptionIcon('heroicon-m-currency-dollar')
            ->description("Barcha foydalanuvchilar balansining umumiy miqdori"),
        Stat::make("Jami bonus promo kodlar soni", \App\Models\Bonus::count() . ' ta')
            ->color("secondary")
            ->descriptionIcon('heroicon-m-gift')
            ->description("Barcha bonuslar soni"),
        ];
        return $stats;
    }
    private function getUsersPerDay(): array
    {
        $now = Carbon::now();
        $usersPerDay = [];

        $days = collect(range(0, 6))->map(function ($day) use ($now, &$usersPerDay) {
            // Subtract days from the current day to get the date for each day of the week
            $date = $now->subDays($day);

            $count = BotUser::whereDate('created_at', $date)->count();
            $usersPerDay[] = $count;

            return $date->format('D M j'); // For format like "Wed Sep 28"
        })->toArray();  // reverse the collection to start from 7 days ago

        return [
            'usersPerDay' => array_reverse($usersPerDay),
            'days' => $days
        ];
    }
}
