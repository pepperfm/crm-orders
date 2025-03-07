<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Repositories\User\UserRepositoryContract;

class UserService
{
    public function __construct(
        public UserRepositoryContract $repository,
    ) {
    }

    public function get(array $relations = []): \Illuminate\Support\Collection
    {
        return $this->repository->get($relations);
    }
}
