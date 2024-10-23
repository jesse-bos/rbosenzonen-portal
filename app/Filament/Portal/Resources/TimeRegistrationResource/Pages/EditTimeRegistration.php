<?php

namespace App\Filament\Portal\Resources\TimeRegistrationResource\Pages;

use App\Filament\Portal\Resources\TimeRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTimeRegistration extends EditRecord
{
    protected static string $resource = TimeRegistrationResource::class;

    protected static ?string $breadcrumb = 'Aanpassen';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Uren Aanpassen';
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
