<?php

namespace App\Filament\Portal\Resources\TimeRegistrationResource\Pages;

use App\Filament\Portal\Resources\TimeRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTimeRegistrations extends ListRecords
{
    protected static string $resource = TimeRegistrationResource::class;

    protected static ?string $breadcrumb = 'Lijst';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Nieuwe registratie'),
        ];
    }

    public function getTitle(): string
    {
        return 'Uren registraties';
    }
}