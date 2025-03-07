<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum OrderStatusEnum: int implements HasColor, HasLabel
{
    case New = 0;

    case Done = 1;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::New => 'Новый',
            self::Done => 'Выполнен',
        };
    }

    public function getColor(): null|array|string
    {
        return match ($this) {
            self::New => 'gray',
            self::Done => 'success',
        };
    }
}
