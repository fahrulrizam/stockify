<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Pastikan Role ID Admin adalah 1 (sesuaikan jika berbeda)
        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@stockify.com',
            'password' => Hash::make('123456'), // Password 123456 akan di-hash
            'role_id'  => 'admin', // Asumsikan ID Role Admin adalah 1
        ]);
    }
}