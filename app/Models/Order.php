<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\OrderStatusEnum;

class Order extends Model
{
    use HasFactory;

    protected $attributes = [
        'status' => OrderStatusEnum::New,
    ];

    protected function casts(): array
    {
        return [
            'status' => OrderStatusEnum::class,
        ];
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
