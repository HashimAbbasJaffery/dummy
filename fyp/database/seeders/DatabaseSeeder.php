<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create a test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Insert jobs directly
        Project::insert([
            [
                'title' => 'Laravel Developer',
                'description' => 'Join our backend team to build high-performance Laravel applications.',
                'skills' => 'Laravel, PHP, MySQL, REST API, Git',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Vue.js Frontend Engineer',
                'description' => 'Looking for a frontend developer to work with Vue 3 and Tailwind CSS.',
                'skills' => 'Vue.js, JavaScript, Tailwind CSS, HTML, CSS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'DevOps Engineer',
                'description' => 'Maintain CI/CD pipelines, server infrastructure, and monitoring tools.',
                'skills' => 'Docker, AWS, Jenkins, Linux, Bash',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
