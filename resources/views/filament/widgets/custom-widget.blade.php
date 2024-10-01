<x-filament-widgets::widget>
    <x-filament::card>
        <div class="flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0">
            <div>
                <h2 class="text-base sm:text-lg font-semibold">
                    {{ __('Custom Widget') }}
                </h2>
                <p class="text-xs text-gray-500">Admin panel by Vermino</p>
            </div>
            <x-filament::button
                href="https://t.me/vermino"
                target="_blank"
                rel="noopener noreferrer"
                icon="heroicon-o-paper-airplane"
                size="sm"
                color="primary"
                style="background-color: #0088cc; border-color: #0088cc;"
            >
                Telegram
            </x-filament::button>
        </div>
    </x-filament::card>
</x-filament-widgets::widget>