<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubModulesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sub_modules')->insert([
            [
                'module_id' => 5,
                'title' => 'Academic Assessment',
                'slug' => Str::slug('Academic Assessment'),
                'description' => 'Evaluate academic skills through targeted assessments.',
                'link' => '/student/edu-center/assessment/academic',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'module_id' => 5,
                'title' => 'Psychological Assessment',
                'slug' => Str::slug('Psychological Assessment'),
                'description' => 'Assess your psychological well-being.',
                'link' => '/student/edu-center/assessment/psychological',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'module_id' => 5,
                'title' => 'Physical Assessment',
                'slug' => Str::slug('Physical Assessment'),
                'description' => 'Measure your physical fitness and abilities.',
                'link' => '/student/edu-center/assessment/physical',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'module_id' => 5,
                'title' => 'Health Assessment',
                'slug' => Str::slug('Health Assessment'),
                'description' => 'Comprehensive health evaluation.',
                'link' => '/student/edu-center/assessment/health',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
