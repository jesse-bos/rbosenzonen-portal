<?php

namespace App\Filament\Admin\Resources\TimeRegistrationResource\Pages;

use App\Filament\Admin\Resources\TimeRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTimeRegistrations extends ListRecords
{
    protected static string $resource = TimeRegistrationResource::class;

    protected static ?string $breadcrumb = 'Overzicht';

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTitle(): string
    {
        return 'Uren Overzicht';
    }
}
