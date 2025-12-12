<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Avatar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $avatarIds = Avatar::pluck('avatar_id')->toArray();

        $users = [
            [
                'username' => 'admin',
                'email' => 'admin@flashify.com',
                'password' => Hash::make('password123'),
                'avatar_id' => $avatarIds[array_rand($avatarIds)],
                'email_verified_at' => now(),
            ],
            [
                'username' => 'john_doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password123'),
                'avatar_id' => $avatarIds[array_rand($avatarIds)],
                'email_verified_at' => now(),
            ],
            [
                'username' => 'jane_smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password123'),
                'avatar_id' => $avatarIds[array_rand($avatarIds)],
                'email_verified_at' => now(),
            ],
            [
                'username' => 'developer',
                'email' => 'dev@flashify.com',
                'password' => Hash::make('password123'),
                'avatar_id' => $avatarIds[array_rand($avatarIds)],
                'email_verified_at' => now(),
            ],
            [
                'username' => 'student',
                'email' => 'student@example.com',
                'password' => Hash::make('password123'),
                'avatar_id' => $avatarIds[array_rand($avatarIds)],
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
