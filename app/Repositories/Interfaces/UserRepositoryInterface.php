<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function create(array $data): User;

    public function findByEmail(string $email): ?User;

    public function logout(User $user): bool;

    public function find(int $id): ?User;
}
