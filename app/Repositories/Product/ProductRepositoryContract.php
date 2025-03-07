<?php

declare(strict_types=1);

namespace App\Repositories\Product;

use Illuminate\Support\Collection;
use App\Data\Product\Requests\SaveRequest;
use App\Models\Product;

interface ProductRepositoryContract
{
    public function find(string $id, array $relations): Product;

    public function get(array $relations): Collection;

    public function paginate(array $relations): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    public function create(SaveRequest $data): void;

    public function update(SaveRequest $data): void;

    public function delete(string $id): void;
}
