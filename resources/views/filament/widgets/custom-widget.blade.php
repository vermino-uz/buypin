<x-filament-widgets::widget class="fi-account-widget">
    <x-filament::card>
        <div class="flex items-center gap-x-3">
            <div class="flex-1 flex flex-col justify-between h-full">
                <div>
                    <h2 class="text-lg sm:text-xl font-bold tracking-tight">
                        {{ __('Custom Widget') }}
                    </h2>
                    <p class="text-sm text-gray-500">Admin panel by Vermino</p>
                </div>
                <div class="mt-4">
                    <x-filament::button
                        href="https://t.me/vermino"
                        target="_blank"
                        rel="noopener noreferrer"
                        icon="heroicon-o-paper-airplane"
                        class="w-full justify-center"
                        color="primary"
                        style="background-color: #0088cc; border-color: #0088cc;"
                    >
                        Telegram
                    </x-filament::button>
                </div>
            </div>
        </div>
    </x-filament::card>
</x-filament-widgets::widget>