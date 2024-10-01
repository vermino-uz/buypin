<x-filament-widgets::widget>
    <x-filament::card class="p-4">
        <div class="flex justify-between items-center">

            <div class="flex flex-col">
                <h2 class="text-lg sm:text-xl font-bold tracking-tight">
                    {{ __('Custom Widget') }}
                </h2>
                <p class="text-sm text-gray-500">Admin panel by Vermino</p>
            </div>

            <div class="flex items-center">
                <x-filament::button
                    href="https://t.me/vermino"
                    target="_blank"
                    rel="noopener noreferrer"
                    icon="heroicon-o-paper-airplane"
                    class="self-center text-sm px-3 py-1"
                    color="primary"
                    style="background-color: #0088cc; border-color: #0088cc;"
                >
                    Telegram
                </x-filament::button>
            </div>

        </div>
    </x-filament::card>
</x-filament-widgets::widget>