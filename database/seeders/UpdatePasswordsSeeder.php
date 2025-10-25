<?php
       namespace Database\Seeders;
       use App\Models\User;
       use Illuminate\Database\Seeder;
       use Illuminate\Support\Facades\Hash;
       class UpdatePasswordsSeeder extends Seeder
       {
           public function run()
           {
               User::all()->each(function ($user) {
                   
                   if (strlen($user->password) < 60 || !password_get_info($user->password)['algo']) {
                       $user->password = Hash::make('default_password'); 
                       $user->save();
                   }
               });
           }
       }