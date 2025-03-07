<?php

declare(strict_types=1);

namespace App\Services\Order;

use App\Repositories\Order\OrderRepositoryContract;
use App\Data\Order\Requests\StoreRequest;
use App\Data\Order\Requests\UpdateRequest;
use App\Models\Order;

class OrderService
{
    public function __construct(
        protected OrderRepositoryContract $repository
    ) {
    }

    public function find(string $id, array $relations = []): Order
    {
        return $this->repository->find($id, $relations);
    }

    /**
     * @param array $relations
     *
     * @return \Illuminate\Support\Collection<array-key, Order>
     */
    public function get(array $relations = []): \Illuminate\Support\Collection
    {
        return $this->repository->get($relations);
    }

    public function paginate(array $relations = []): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->repository->paginate($relations);
    }

    public function create(StoreRequest $data): void
    {
        $this->repository->create($data);
    }

    public function update(UpdateRequest $data): void
    {
        $this->repository->update($data);
    }

    public function delete(string $id): void
    {
        $this->repository->delete($id);
    }
}
