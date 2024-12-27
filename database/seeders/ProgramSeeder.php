<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Program::create(['name' => 'Kedokteran', 'description' => 'Program pendidikan kedokteran.']);
        Program::create(['name' => 'Teknik', 'description' => 'Program pendidikan teknik.']);
        Program::create(['name' => 'Ekonomi', 'description' => 'Program pendidikan ekonomi.']);
    }
}
