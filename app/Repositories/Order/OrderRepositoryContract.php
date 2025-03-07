<?php

declare(strict_types=1);

namespace App\Repositories\Order;

use Illuminate\Support\Collection;
use App\Data\Order\Requests\StoreRequest;
use App\Data\Order\Requests\UpdateRequest;
use App\Models\Order;

interface OrderRepositoryContract
{
    public function find(string $id, array $relations): Order;

    public function get(array $relations): Collection;

    public function paginate(array $relations): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    public function create(StoreRequest $data): void;

    public function update(UpdateRequest $data): void;

    public function delete(string $id): void;
}
