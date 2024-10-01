<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class BlogPostsChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [
            'datasets' => [
                'label' => 'Blog Posts',
                'data' => [10, 20, 30, 40, 50, 60, 70, 80, 90, 100],
            ],
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
