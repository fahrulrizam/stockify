<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // RoleSeeder HARUS dijalankan pertama
             
            
            // Kemudian, AdminUserSeeder dijalankan untuk membuat user
            AdminUserSeeder::class, 
            
            // Seeder lain yang mungkin Anda miliki
            // UpdatePasswordsSeeder::class, // (Jika diperlukan)
            // RolePermissionSeeder::class, // (Jika diperlukan)
        ]);
    }
}