<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run()
    {
        Brand::create(['name' => 'Educate', 'description' => 'Educational Platform']);
        Brand::create(['name' => 'Bintang Bangsa', 'description' => 'Support for Nation Leaders']);
        Brand::create(['name' => 'Sukses CPNS', 'description' => 'Training for Government Exam']);
    }
}
