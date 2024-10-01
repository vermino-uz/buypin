<x-filament-widgets::widget>
    <x-filament::card>
        <div class="flex justify-between items-center space-x-5">
            <h2 class="text-sm font-medium">
                {{ __('Custom Widget') }}
            </h2>
            <x-filament::button
                href="https://t.me/vermino"
                target="_blank"
                rel="noopener noreferrer"
                icon="heroicon-o-paper-airplane"
                size="xs"
                color="primary"
                style="background-color: #0088cc; border-color: #0088cc;"
            >
                Telegram
            </x-filament::button>
        </div>
    </x-filament::card>
</x-filament-widgets::widget>