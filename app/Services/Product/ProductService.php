<?php

declare(strict_types=1);

namespace App\Services\Product;

use App\Data\Product\Requests\SaveRequest;
use App\Repositories\Product\ProductRepositoryContract;
use App\Models\Product;

class ProductService
{
    public function __construct(
        protected ProductRepositoryContract $repository
    ) {
    }

    public function find(string $id, array $relations = []): Product
    {
        return $this->repository->find($id, $relations);
    }

    /**
     * @param array $relations
     *
     * @return \Illuminate\Support\Collection<array-key, Product>
     */
    public function get(array $relations = []): \Illuminate\Support\Collection
    {
        return $this->repository->get($relations);
    }

    public function paginate(array $relations = []): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->repository->paginate($relations);
    }

    public function create(SaveRequest $data): void
    {
        $this->repository->create($data);
    }

    public function update(SaveRequest $data): void
    {
        $this->repository->update($data);
    }

    public function delete(string $id): void
    {
        $this->repository->delete($id);
    }
}
