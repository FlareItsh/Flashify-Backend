<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\User;
use Illuminate\Database\Seeder;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        $collections = [
            [
                'name' => 'JavaScript Fundamentals',
                'tags' => ['programming', 'javascript', 'web development'],
                'priority_level' => 'high',
            ],
            [
                'name' => 'PHP Laravel',
                'tags' => ['php', 'laravel', 'backend'],
                'priority_level' => 'high',
            ],
            [
                'name' => 'Database Design',
                'tags' => ['database', 'sql', 'mysql'],
                'priority_level' => 'medium',
            ],
            [
                'name' => 'React Basics',
                'tags' => ['react', 'javascript', 'frontend'],
                'priority_level' => 'medium',
            ],
            [
                'name' => 'Python Programming',
                'tags' => ['python', 'programming', 'data science'],
                'priority_level' => 'low',
            ],
            [
                'name' => 'Git & Version Control',
                'tags' => ['git', 'version control', 'development'],
                'priority_level' => 'medium',
            ],
            [
                'name' => 'REST API Design',
                'tags' => ['api', 'rest', 'backend'],
                'priority_level' => 'high',
            ],
            [
                'name' => 'CSS Styling',
                'tags' => ['css', 'frontend', 'design'],
                'priority_level' => 'low',
            ],
            [
                'name' => 'Docker Basics',
                'tags' => ['docker', 'devops', 'containers'],
                'priority_level' => 'medium',
            ],
            [
                'name' => 'Algorithm & Data Structures',
                'tags' => ['algorithms', 'data structures', 'computer science'],
                'priority_level' => 'high',
            ],
        ];

        foreach ($users as $user) {
            // Create 2-3 collections per user
            $userCollections = array_rand($collections, rand(2, 7));

            if (!is_array($userCollections)) {
                $userCollections = [$userCollections];
            }

            foreach ($userCollections as $index) {
                Collection::create([
                    'user_id' => $user->user_id,
                    'name' => $collections[$index]['name'],
                    'tags' => $collections[$index]['tags'],
                    'priority_level' => $collections[$index]['priority_level'],
                ]);
            }
        }
    }
}
