<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pesanans')->insert([
            [
                'idpesanan' => 1,
                'idmeja' => 1,
                'iduser_waiter' => 2,
                'status' => 'OPEN',
                'total' => 25000,
            ],
        ]);
    }
}
