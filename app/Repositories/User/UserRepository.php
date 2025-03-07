<?php

declare(strict_types=1);

namespace App\Repositories\User;

use Illuminate\Support\Collection;
use App\Models\User;

readonly class UserRepository implements UserRepositoryContract
{
    public function __construct(
        private User $model
    ) {
    }

    public function get(array $relations): Collection
    {
        return $this->model
            ->newQuery()
            ->where('is_admin', false)
            ->with($relations)
            ->get();
    }
}
