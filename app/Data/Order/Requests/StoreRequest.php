<?php

declare(strict_types=1);

namespace App\Data\Order\Requests;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapName;
use App\Services\Product\ProductService;

class StoreRequest extends Data
{
    public function __construct(
        #[MapName('user_id')]
        public int $userId,
        #[MapName('product_id')]
        public int $productId,
        public ?float $sum,
    ) {
        $this->sum = (float) resolve(ProductService::class)->find((string) $this->productId)->price;
    }
}
