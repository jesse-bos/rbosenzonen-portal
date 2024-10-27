<?php

namespace App\Filament\Portal\Resources\TimeRegistrationResource\Widgets;

use App\Models\User;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TimeRegistrationForTodayWidget extends Widget
{
    protected static string $view = 'filament.portal.resources.time-registration-resource.widgets.time-registration-status';

    protected int | string | array $columnSpan = 2;

    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        /** @var User $user */
        $user = Auth::user();
        return ! $user->hasTimeRegistrationForToday();
    }
}
