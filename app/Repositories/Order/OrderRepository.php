<?php

declare(strict_types=1);

namespace App\Repositories\Order;

use Illuminate\Support\Collection;
use App\Data\Order\Requests\StoreRequest;
use App\Data\Order\Requests\UpdateRequest;
use App\Models\Order;

readonly class OrderRepository implements OrderRepositoryContract
{
    public function __construct(
        private Order $model
    ) {
    }

    public function find(string $id, array $relations): Order
    {
        return $this->model
            ->newQuery()
            ->findOrFail($id)
            ->load($relations);
    }

    public function get(array $relations): Collection
    {
        return $this->model
            ->newQuery()
            ->with($relations)
            ->get();
    }

    public function paginate(array $relations): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $request = request();

        return $this->model
            ->newQuery()
            ->with($relations)
            ->when(
                $request->input('order_by') && $request->input('direction'),
                static fn($query) => $query->orderBy(
                    column: $request->input('order_by', 'created_at'),
                    direction: $request->input('direction', 'desc'),
                )
            )
            ->paginate(
                perPage: $request->input('per_page', 10),
                page: $request->input('page', 1),
            );
    }

    public function create(StoreRequest $data): void
    {
        $this->model->newInstance($data->toArray())->save();
    }

    public function update(UpdateRequest $data): void
    {
        $this->model->newInstance($data->toArray(), true)->save();
    }

    public function delete(string $id): void
    {
        $this->model->newInstance(['id' => $id], true)->delete();
    }
}
