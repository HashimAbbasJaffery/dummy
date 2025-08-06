<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;

class JobSeeder extends Seeder
{
    public function run()
    {
        Job::insert([
            [
                'title' => 'Senior Laravel Developer',
                'description' => 'We are looking for a Laravel expert with experience in large-scale applications.',
                'skills' => 'Laravel, PHP, MySQL, REST API, Git',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Frontend Engineer (Vue.js)',
                'description' => 'Join our frontend team to work on stunning interfaces using Vue.js and Tailwind CSS.',
                'skills' => 'Vue.js, JavaScript, Tailwind CSS, HTML, CSS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'DevOps Engineer',
                'description' => 'Responsible for CI/CD pipelines, infrastructure management, and monitoring.',
                'skills' => 'Docker, AWS, Jenkins, Linux, Bash',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
