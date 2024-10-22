<?php

namespace App\Filament\Admin\Resources\TimeRegistrationResource\Pages;

use App\Filament\Admin\Resources\TimeRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTimeRegistration extends EditRecord
{
    protected static string $resource = TimeRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
