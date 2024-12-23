<?php

namespace App\Filament\Admin\Resources\TimeRegistrationResource\Pages;

use App\Filament\Admin\Resources\TimeRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTimeRegistration extends ViewRecord
{
    protected static string $resource = TimeRegistrationResource::class;

    protected static ?string $breadcrumb = 'Bekijken';

    public function getTitle(): string
    {
        return 'Uren';
    }
}
