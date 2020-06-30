<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        if (!User::where('email', 'dan@shinton.net')->exists()) {
            $now = new DateTime();
            DB::table('users')->insert([
                'name' => 'Dan Shinton',
                'email' => 'dan@shinton.net',
                'password' => Hash::make('password'),
                'created_at' => $now,
                'updated_at' => $now,
                'role' => 'admin',
                'enabled' => true
            ]);
        }
    }
}
