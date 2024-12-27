<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KkmDetailsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('kkm_details')->insert([
            [
                'target_id' => 7, 
                'subject' => 'PULL UP (x)',
                'kkm' => json_encode(['jumlah' => 80, 'nilai' => 130]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
