<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Nata', 'email' => 'nata@gmail.com', 'role' => 'admin'],
            ['name' => 'Ryan', 'email' => 'ryan@gmail.com', 'role' => 'user'],
            ['name' => 'Vitor', 'email' => 'vitor@gmail.com', 'role' => 'user'],
            ['name' => 'Aguida', 'email' => 'aguida@gmail.com', 'role' => 'user'],
            ['name' => 'Gabriel', 'email' => 'gabriel@gmail.com', 'role' => 'user'],
            ['name' => 'Eduardo', 'email' => 'eduardo@gmail.com', 'role' => 'user'],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => '123456',
                    'role' => $userData['role'],
                ]
            );
        }
    }
}
