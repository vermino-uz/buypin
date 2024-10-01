<x-filament-widgets::widget>
    <x-filament::card>
        <div class="h-12 flex items-center space-x-4 rtl:space-x-reverse">
            <h2 class="text-lg sm:text-xl font-bold tracking-tight">
                {{ __('Custom Widget') }}
            </h2>
        </div>

        {{-- Add your custom widget content here --}}
        <p>Admin panel by Vermino</p>
        <x-filament::button
            href="https://t.me/vermino"
            target="_blank"
            rel="noopener noreferrer"
            icon="heroicon-o-paper-airplane"
        >
            Telegram
        </x-filament::button>
    </x-filament::card>
</x-filament-widgets::widget>