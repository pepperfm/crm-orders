<?php

declare(strict_types=1);

namespace App\Data\Order\Requests;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\FromRouteParameter;

class UpdateRequest extends Data
{
    public function __construct(
        #[FromRouteParameter('order')]
        public int $id,
        #[MapName('user_id')]
        public int $userId,
        #[MapName('product_id')]
        public int $productId,
    ) {
    }
}
