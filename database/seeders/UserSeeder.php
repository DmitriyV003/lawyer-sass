<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => 'John',
            'email' => 'example2@mail.com',
            'lastname' => 'Doe',
            'phone' => '79269369161',
            'surname' => 'Петрович',
            'type' => UserType::Lawyer,
            'password' => Hash::make('secret12'),
        ]);
        $user->assignRole(User::ADVOCATE_ROLE);
    }
}
