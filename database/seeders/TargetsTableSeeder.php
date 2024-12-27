<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TargetsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('targets')->insert([
            [
                'user_id' => 4,
                'title' => 'Akademik',
                'slug' => Str::slug('Akademik'),
                'description' => 'Target akademik seperti nilai ujian.',
                'schedule' => '2024-08-07',
                'time' => '07:00 - 17:00',
                'icon' => 'A',
                'color' => 'bg-primary',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'title' => 'Psikologi',
                'slug' => Str::slug('Psikologi'),
                'description' => 'Target kesehatan mental dan emosional.',
                'schedule' => '2024-08-08',
                'time' => '07:00 - 17:00',
                'icon' => 'P',
                'color' => 'bg-success',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'title' => 'Jasmani',
                'slug' => Str::slug('Jasmani'),
                'description' => 'Target kesehatan fisik.',
                'schedule' => '2024-08-09',
                'time' => '07:00 - 17:00',
                'icon' => 'J',
                'color' => 'bg-info',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'title' => 'Kesehatan',
                'slug' => Str::slug('Kesehatan'),
                'description' => 'Target kesehatan tubuh secara umum.',
                'schedule' => '2024-08-10',
                'time' => '07:00 - 17:00',
                'icon' => 'H',
                'color' => 'bg-danger',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'title' => 'PULL UP (x)',
                'slug' => Str::slug('PULL UP (x)'),
                'description' => 'Target fisik untuk pull up.',
                'schedule' => '2024-08-11',
                'time' => '07:00 - 17:00',
                'icon' => 'PU',
                'color' => 'bg-warning',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
