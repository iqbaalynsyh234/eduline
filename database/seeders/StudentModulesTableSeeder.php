<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentModulesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('student_modules')->insert([
            [
                'user_id' => 4,
                'title' => 'Assessment',
                'slug' => Str::slug('Assessment'),
                'description' => 'Evaluate your skills through assessments designed for you.',
                'image' => '/images/assessment.png',
                'link' => '/student/edu-center/module/assessment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'title' => 'Drilling Soal',
                'slug' => Str::slug('Drilling Soal'),
                'description' => 'Practice with drilling exercises to master topics.',
                'image' => '/images/drilling.png',
                'link' => '/student/edu-center/module/drilling-soal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'title' => 'E - Modul',
                'slug' => Str::slug('E - Modul'),
                'description' => 'Access digital learning materials to expand your knowledge.',
                'image' => '/images/e-modul.png',
                'link' => '/student/edu-center/module/e-modul',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'title' => 'Tryout',
                'slug' => Str::slug('Tryout'),
                'description' => 'Simulate real tests to prepare yourself better.',
                'image' => '/images/tryout.png',
                'link' => '/student/edu-center/module/tryout',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
