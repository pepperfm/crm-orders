<?php

declare(strict_types=1);

namespace App\Services\Category;

use App\Repositories\Category\CategoryRepositoryContract;

class CategoryService
{
    public function __construct(
        protected CategoryRepositoryContract $repository
    ) {
    }

    /**
     * @param array $relations
     *
     * @return \Illuminate\Support\Collection<array-key, \App\Models\Category>
     */
    public function get(array $relations = []): \Illuminate\Support\Collection
    {
        return $this->repository->get($relations);
    }
}
