<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Nata', 'email' => 'nata@gmail.com'],
            ['name' => 'Ryan', 'email' => 'ryan@gmail.com'],
            ['name' => 'Vitor', 'email' => 'vitor@gmail.com'],
            ['name' => 'Aguida', 'email' => 'aguida@gmail.com'],
            ['name' => 'Gabriel', 'email' => 'gabriel@gmail.com'],
            ['name' => 'Eduardo', 'email' => 'eduardo@gmail.com'],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('123456', ['rounds' => 12]),
                ]
            );
        }
    }
}
