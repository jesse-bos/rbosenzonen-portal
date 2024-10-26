<x-filament-widgets::widget>
    <x-filament::section
        icon="heroicon-o-clock"
        heading="Urenregistratie">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between w-full h-64 space-y-4 sm:space-y-0">
            @if ($this->hasRegisteredTimeToday())
            <div>Je hebt vandaag uren geboekt</div>
            <x-filament::button
                href="{{ route('filament.portal.resources.time-registrations.index') }}"
                tag="a">
            </x-filament::button>
            @else
            <div><span class="text-success-500">Je hebt vandaag nog geen uren geboekt!</span></div>
            <x-filament::button
                href="{{ route('filament.portal.resources.time-registrations.create') }}"
                tag="a"
                color="warning"
                icon="heroicon-o-clock">
                Uren Boeken
            </x-filament::button>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>