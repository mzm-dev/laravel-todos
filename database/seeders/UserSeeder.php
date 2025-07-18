<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'super@todo.com',
                'role' => 'Super Admin',
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@todo.com',
                'role' => 'Admin',
            ],
            [
                'name' => 'Normal User',
                'email' => 'user@todo.com',
                'role' => 'User',
            ],
        ];

        foreach ($users as $u) {
            $user = User::factory()->create(
                [
                    'email' => $u['email'],
                    'name' => $u['name'],
                    'password' => 'password'
                ]
            );

            $user->assignRole($u['role']);
        }
    }
}
