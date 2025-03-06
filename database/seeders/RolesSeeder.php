<?php

namespace Database\Seeders;

use App\Services\RoleService;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function __construct(private RoleService $roleService)
    {
    }

    public function run(): void
    {
        $this->roleService->firstOrCreate(['name' => 'user']);
        $this->roleService->firstOrCreate(['name' => 'admin']);
    }
}
