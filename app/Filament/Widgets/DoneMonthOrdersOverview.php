<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;
use App\Enums\OrderStatusEnum;

class DoneMonthOrdersOverview extends BaseWidget
{
    protected static ?int $sort = -2;

    protected array|int|string $columnStart = 1;

    protected array|int|string $columnSpan = 2;

    protected static ?string $pollingInterval = '10m';

    protected function getStats(): array
    {
        $orders = \App\Models\Order::query()
            ->where('created_at', '>=', now()->startOfMonth()->startOfDay())
            ->where('created_at', '<=', now()->endOfMonth()->endOfDay())
            ->where('status', OrderStatusEnum::Done)
            ->get();

        $count = $orders->count();
        $sum = $orders->sum('sum');
        $formatted = $sum === 0 ? '-' : Number::currency($sum, in: 'RUB', locale: 'ru');

        return [
            Stat::make('Выполненных заказов в этом месяце', $count === 0 ? '-' : $count)
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make('На сумму', $formatted)
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
        ];
    }

    public function getColumns(): int
    {
        return 2;
    }
}
