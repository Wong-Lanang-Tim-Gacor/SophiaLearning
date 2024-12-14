<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\UserInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\User;

class UserRepository extends BaseRepository implements UserInterface
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function update(mixed $id, array $data): bool
    {
        return $this->show($id)->update($data);
    }

    public function show(mixed $id): mixed
    {
        return $this->model
            ->query()
            ->findOrFail($id);
    }
}
