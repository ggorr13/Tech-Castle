<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface AuthRepositoryInterface
{
    public function createToken(User $user): string;

    public function logout(User $user): bool;
}
