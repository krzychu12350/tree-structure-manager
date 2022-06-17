<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => 'Admin?password123',
                'role' => 'admin',
            ],
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'password' => 'User?password123',
                'role' => 'user',
            ],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'role' => $user['role'],
            ]);
        }
    }
}
