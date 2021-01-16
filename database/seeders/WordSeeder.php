<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $words = ['vacation', 'action', 'auction', 'caution', 'vacant', 'count', 'covin', 'tonic', 'octan', 'anti',
            'aunt', 'auto', 'coat', 'coin', 'icon', 'into', 'tuna', 'act', 'can', 'cat', 'nut'];
        foreach ($words as $key) {
            DB::table('words')->insert([
                'name' => $key,
                'created_at' => date('Y/m/d H:i:s'),
                'updated_at' => date('Y/m/d H:i:s')
            ]);
        }
        
    }
}
