<?php

declare(strict_types=1);

namespace App\Repositories\Category;

use Illuminate\Support\Collection;

interface CategoryRepositoryContract
{
    public function get(array $relations): Collection;
}
