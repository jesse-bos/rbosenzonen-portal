<?php

namespace App\Filament\Portal\Resources\TimeRegistrationResource\Pages;

use App\Filament\Portal\Resources\TimeRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateTimeRegistration extends CreateRecord
{
    protected static string $resource = TimeRegistrationResource::class;

    protected static ?string $breadcrumb = 'Aanmaken';

    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
     
        return $data;
    }

    public function getTitle(): string
    {
        return 'Urenregistratie Aanmaken';
    }
}
