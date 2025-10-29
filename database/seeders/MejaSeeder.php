<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class MejaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mejas')->insert([
            ['idmeja' => 1, 'nomor_meja' => 'A1', 'kapasitas' => 4, 'status' => 'AVAILABLE'],
            ['idmeja' => 2, 'nomor_meja' => 'A2', 'kapasitas' => 2, 'status' => 'OCCUPIED'],
        ]);
    }
}
