<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    public function create(array $data): User
    {
        return User::query()->create($data);
    }

    public function findByEmail(string $email): ?User
    {
        return User::query()->where('email', $email)->first();
    }

    public function logout(User $user): bool
    {
        return $user->tokens()->delete();
    }

    public function find(int $id): ?User
    {
        return User::query()->find($id);
    }
}
