<?php

declare(strict_types=1);

namespace App\Data\Product\Requests;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\FromRouteParameter;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Optional;
use App\Models\Category;

class SaveRequest extends Data
{
    public function __construct(
        #[FromRouteParameter('product')]
        public Optional|string $id,
        public string $name,
        public string $description,
        #[MapName('category_id'), Exists(Category::class, 'id')]
        public int $categoryId,
        public float $price,
    ) {
    }
}
