<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RoleRepositoryInterface;
use Spatie\Permission\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{

    public function firstOrCreate(array $data): Role
    {
        return Role::query()->firstOrCreate($data);
    }
}
