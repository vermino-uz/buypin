<x-filament-widgets::widget>
    <x-filament::card>
        <div class="flex justify-between items-center space-x-4">
            <div>
                <h2 class="text-lg font-bold tracking-tight">{{ __('Vermino') }}</h2>
                <p class="text-xs text-gray-500">Admin panel by Vermino</p>
            </div>
            <a href="https://t.me/vermino" target="_blank" rel="noopener noreferrer">
                <x-filament::button
                    icon="heroicon-o-paper-airplane"
                    color="primary"
                    size="sm"
                    style="background-color: #0088cc; border-color: #0088cc;"
                >
                    Telegram
                </x-filament::button>
            </a>
        </div>
    </x-filament::card>
</x-filament-widgets::widget>