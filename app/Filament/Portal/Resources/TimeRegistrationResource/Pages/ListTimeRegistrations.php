<?php

namespace App\Filament\Portal\Resources\TimeRegistrationResource\Pages;

use App\Filament\Portal\Resources\TimeRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTimeRegistrations extends ListRecords
{
    protected static string $resource = TimeRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
