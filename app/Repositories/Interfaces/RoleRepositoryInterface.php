<?php

namespace App\Repositories\Interfaces;

use Spatie\Permission\Models\Role;

interface RoleRepositoryInterface
{
    public function firstOrCreate(array $data): Role;
}
