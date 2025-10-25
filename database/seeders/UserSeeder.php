<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@stockify.test'],
            ['name' => 'Admin Stockify', 'password' => Hash::make('AdminPass123!'), 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'manager@stockify.test'],
            ['name' => 'Manajer Stockify', 'password' => Hash::make('ManagerPass123!'), 'role' => 'manager']
        );

        User::updateOrCreate(
            ['email' => 'staff@stockify.test'],
            ['name' => 'Staff Stockify', 'password' => Hash::make('StaffPass123!'), 'role' => 'staff']
        );
    }
}
