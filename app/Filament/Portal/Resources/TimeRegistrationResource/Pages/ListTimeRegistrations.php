<?php

namespace App\Filament\Portal\Resources\TimeRegistrationResource\Pages;

use App\Filament\Portal\Resources\TimeRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListTimeRegistrations extends ListRecords
{
    protected static string $resource = TimeRegistrationResource::class;

    protected static ?string $breadcrumb = 'Overzicht';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Uren Boeken')
                ->icon('heroicon-o-plus'),
        ];
    }

    public function getTitle(): string
    {
        return 'Uren Overzicht - ' . Auth::user()?->name;
    }
}
