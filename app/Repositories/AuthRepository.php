<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{

    public function createToken(User $user): string
    {
        return $user->createToken('token')->plainTextToken;
    }

    public function logout(User $user): bool
    {
        return $user->tokens()->delete();
    }
}
