<?php

namespace App\Filament\Portal\Widgets;

use Filament\Forms\Components\Card;
use Filament\Infolists\Components\Section;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        return [
            Stat::make('Uren deze week', 32.5),
            Stat::make('Kilometers deze week', 348),
            Stat::make('Kilometers dit jaar', 3960),
        ];
    }
}
