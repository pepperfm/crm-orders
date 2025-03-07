<?php

declare(strict_types=1);

namespace App\Data\Product;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;
use Carbon\Carbon;

class ProductData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        public string $price,
        #[MapName('category_id')]
        public int $categoryId,
        #[MapName('created_at'), WithTransformer(DateTimeInterfaceTransformer::class, format: 'd-m-Y H:i')]
        public Carbon $createdAt,
        #[MapName('updated_at'),WithTransformer(DateTimeInterfaceTransformer::class, format: 'd-m-Y H:i')]
        public Carbon $updatedAt,
    ) {
    }
}
