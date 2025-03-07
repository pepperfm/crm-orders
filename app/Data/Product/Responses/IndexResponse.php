<?php

declare(strict_types=1);

namespace App\Data\Product\Responses;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\LoadRelation;
use App\Data\Category\CategoryData;

class IndexResponse extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $price,
        #[LoadRelation]
        public CategoryData $category,
    ) {
    }
}
