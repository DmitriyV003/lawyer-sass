<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
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

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->roles as $role) {
            Role::create($role)->save();
        }
    }
}
