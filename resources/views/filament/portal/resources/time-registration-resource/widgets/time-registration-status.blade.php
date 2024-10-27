<x-filament-widgets::widget>
    <x-filament::section
        icon="heroicon-o-exclamation-triangle"
        heading="Herinnering">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between w-full h-64 space-y-4 sm:space-y-0">
            <div><span class="text-success-500">Je hebt voor vandaag nog geen uren geregistreerd!</span></div>
            <x-filament::button
                href="{{ route('filament.portal.resources.time-registrations.create') }}"
                tag="a"
                
                icon="heroicon-o-plus">
                Uren Registreren
            </x-filament::button>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>