<?php

namespace App\Filament\Portal\Resources\TimeRegistrationResource\Pages;

use App\Filament\Portal\Resources\TimeRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateTimeRegistration extends CreateRecord
{
    protected static string $resource = TimeRegistrationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
     
        return $data;
    }
}
