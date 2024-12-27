<?php

namespace Database\Seeders;

use App\Models\Ebook;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // RolesAndPermissionsSeeder::class, 
            // TargetsTableSeeder::class,
            KkmDetailsTableSeeder::class,     
        ]);
    }

}
