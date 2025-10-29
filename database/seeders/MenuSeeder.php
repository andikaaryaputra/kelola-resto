<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menus')->insert([
            ['idmenu' => 1, 'nama_menu' => 'Nasi Goreng', 'harga' => 20000, 'kategori' => 'Makanan'],
            ['idmenu' => 2, 'nama_menu' => 'Es Teh Manis', 'harga' => 5000, 'kategori' => 'Minuman'],
        ]);
    }
}
