<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        if (!User::where('email', 'dan@shinton.net')->exists()) {
            DB::table('users')->insert([
                'name' => 'Dan Shinton',
                'email' => 'dan@shinton.net',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
