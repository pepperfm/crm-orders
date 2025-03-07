<?php

declare(strict_types=1);

namespace App\Repositories\Product;

use Illuminate\Support\Collection;
use App\Data\Product\Requests\SaveRequest;
use App\Models\Product;

readonly class ProductRepository implements ProductRepositoryContract
{
    public function __construct(
        private Product $model
    ) {
    }

    public function find(string $id, array $relations): Product
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
                fn ($query) => $query->orderBy(
                    column: $request->input('order_by', 'created_at'),
                    direction: $request->input('direction', 'desc'),
                )
            )
            ->paginate(
                perPage: $request->input('per_page', 10),
                page: $request->input('page', 1),
            );
    }

    public function create(SaveRequest $data): void
    {
        $this->model->newInstance($data->toArray())->save();
    }

    public function update(SaveRequest $data): void
    {
        $this->model->newInstance($data->toArray(), true)->save();
    }

    public function delete(string $id): void
    {
        $this->model->newInstance(['id' => $id], true)->delete();
    }
}
