<?php

namespace App\Filament\Portal\Resources\TimeRegistrationResource\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class TimeRegistrationStatus extends Widget
{
    protected static string $view = 'filament.portal.resources.time-registration-resource.widgets.time-registration-status';

    protected int | string | array $columnSpan = 2;

    public function hasRegisteredTimeToday()
    {
        return auth()->user()->timeRegistrations()->where('date', now()->format('Y-m-d'))->exists();
    }

}
