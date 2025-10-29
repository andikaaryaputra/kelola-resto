<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PesananDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pesanan_details')->insert([
            [
                'idpesanan_detail' => 1,
                'idpesanan' => 1,
                'idmenu' => 1,
                'jumlah' => 1,
                'subtotal' => 20000,
            ],
            [
                'idpesanan_detail' => 2,
                'idpesanan' => 1,
                'idmenu' => 2,
                'jumlah' => 1,
                'subtotal' => 5000,
            ],
        ]);
    }
}
