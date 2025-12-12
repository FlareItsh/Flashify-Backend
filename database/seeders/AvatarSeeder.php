<?php

namespace Database\Seeders;

use App\Models\Avatar;
use Illuminate\Database\Seeder;

class AvatarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $avatars = [
            ['file_path' => 'avatars/avatar1.png'],
            ['file_path' => 'avatars/avatar2.png'],
            ['file_path' => 'avatars/avatar3.png'],
            ['file_path' => 'avatars/avatar4.png'],
            ['file_path' => 'avatars/avatar5.png'],
            ['file_path' => 'avatars/avatar6.png'],
            ['file_path' => 'avatars/avatar7.png'],
            ['file_path' => 'avatars/avatar8.png'],
            ['file_path' => 'avatars/avatar9.png'],
            ['file_path' => 'avatars/avatar10.png'],
            ['file_path' => 'avatars/avatar11.png'],
            ['file_path' => 'avatars/avatar12.png'],
            ['file_path' => 'avatars/avatar13.png'],
            ['file_path' => 'avatars/avatar14.png'],
            ['file_path' => 'avatars/avatar15.png'],
            ['file_path' => 'avatars/avatar16.png'],
            ['file_path' => 'avatars/avatar17.png'],
            ['file_path' => 'avatars/avatar18.png'],
            ['file_path' => 'avatars/avatar19.png'],
            ['file_path' => 'avatars/avatar20.png'],
        ];

        foreach ($avatars as $avatar) {
            Avatar::create($avatar);
        }
    }
}
