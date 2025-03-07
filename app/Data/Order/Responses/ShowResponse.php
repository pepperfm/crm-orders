<?php

declare(strict_types=1);

namespace App\Data\Order\Responses;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\WithTransformer;
use Carbon\Carbon;
use App\Data\User\UserData;
use App\Data\Product\ProductData;
use App\Enums\OrderStatusEnum;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

class ShowResponse extends Data
{
    public function __construct(
        public int $id,
        public UserData $user,
        public ProductData $product,
        public OrderStatusEnum $status,
        #[MapName('created_at'), WithTransformer(DateTimeInterfaceTransformer::class, format: 'd.m.Y')]
        public Carbon $createdAt,
    ) {
    }
}
