<?php

namespace Database\Seeders;

use App\Models\Ebook;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        Ebook::create([
            'name' => 'Ebook 1',
            'file_path' => 'ebook/assesment/ebook1.pdf',  
        ]);
    
        Ebook::create([
            'name' => 'Ebook 2',
            'file_path' => 'ebook/assesment/ebook2.pdf',
        ]);
    
        Ebook::create([
            'name' => 'Ebook 3',
            'file_path' => 'ebook/assesment/ebook3.pdf',
        ]);
    }
}
