<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    private array $roles = [
        [
            'name' => 'super admin',
            'guard_name' => 'api',
        ],
        [
            'name' => 'advocate',
            'guard_name' => 'api',
        ]
    ];

    private array $permissions = [
        [
            'name' => 'manage lawsuits',
            'guard_name' => 'api',
        ],
        [
            'name' => 'manage calendar',
            'guard_name' => 'api',
        ],
        [
            'name' => 'manage tasks',
            'guard_name' => 'api',
        ],
        [
            'name' => 'manage notes ',
            'guard_name' => 'api',
        ],
        [
            'name' => 'manage customers',
            'guard_name' => 'api',
        ],
        [
            'name' => 'manage finances',
            'guard_name' => 'api',
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->roles as $role) {
            if (Role::where('name', $role['name'])->exists()) {
                continue;
            }
            Role::create($role)->save();
        }

        foreach ($this->permissions as $permission) {
            if (Permission::where('name', $permission['name'])->exists()) {
                continue;
            }
            Permission::create($permission)->save();
        }
    }
}
