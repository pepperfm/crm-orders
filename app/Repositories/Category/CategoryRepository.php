<?php

declare(strict_types=1);

namespace App\Repositories\Category;

use Illuminate\Support\Collection;
use App\Models\Category;

readonly class CategoryRepository implements CategoryRepositoryContract
{
    public function __construct(
        private Category $model
    ) {
    }


    public function get(array $relations): Collection
    {
        return $this->model
            ->newQuery()
            ->with($relations)
            ->get();
    }
}
