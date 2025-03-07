<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserService
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function findByEmail(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }

    public function create(array $data): User
    {
        return $this->userRepository->create($data);
    }

    public function find(int $id): ?User
    {
        return $this->userRepository->find($id);
    }
}
