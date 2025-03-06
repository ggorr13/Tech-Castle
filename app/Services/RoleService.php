<?php

namespace App\Services;

use App\Repositories\Interfaces\RoleRepositoryInterface;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function __construct(private RoleRepositoryInterface $roleRepository)
    {
    }

    public function firstOrCreate(array $data): Role
    {
        return $this->roleRepository->firstOrCreate($data);
    }
}
