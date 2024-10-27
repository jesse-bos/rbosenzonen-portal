<?php

namespace App\Filament\Portal\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = '2';

    protected function getStats(): array
    {
        /** @var User $user */
        $user = Auth::user();

        return [
            Stat::make('Uren deze week', $user->getHoursThisWeek()),
            Stat::make('Kilometers deze week', 348),
            Stat::make('Kilometers dit jaar', 3960),
        ];
    }
}
