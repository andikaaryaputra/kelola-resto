<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meja;
use App\Models\Menu;
use App\Models\Pelanggan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Users
        $this->call(UserSeeder::class);

        // Seed Meja
        $mejas = [
            ['nomormeja' => 'A1', 'kapasitas' => 4, 'status' => 'kosong'],
            ['nomormeja' => 'A2', 'kapasitas' => 4, 'status' => 'kosong'],
            ['nomormeja' => 'A3', 'kapasitas' => 6, 'status' => 'kosong'],
            ['nomormeja' => 'B1', 'kapasitas' => 2, 'status' => 'kosong'],
            ['nomormeja' => 'B2', 'kapasitas' => 2, 'status' => 'kosong'],
            ['nomormeja' => 'B3', 'kapasitas' => 8, 'status' => 'kosong'],
            ['nomormeja' => 'C1', 'kapasitas' => 4, 'status' => 'kosong'],
            ['nomormeja' => 'C2', 'kapasitas' => 6, 'status' => 'kosong'],
        ];

        foreach ($mejas as $meja) {
            Meja::create($meja);
        }

        // Seed Menu
        $menus = [
            ['namamenu' => 'Nasi Goreng Spesial', 'harga' => 25000, 'aktif' => true],
            ['namamenu' => 'Mie Ayam', 'harga' => 18000, 'aktif' => true],
            ['namamenu' => 'Gado-gado', 'harga' => 20000, 'aktif' => true],
            ['namamenu' => 'Sate Ayam (10 tusuk)', 'harga' => 30000, 'aktif' => true],
            ['namamenu' => 'Rendang Daging', 'harga' => 35000, 'aktif' => true],
            ['namamenu' => 'Ayam Bakar', 'harga' => 28000, 'aktif' => true],
            ['namamenu' => 'Es Teh Manis', 'harga' => 5000, 'aktif' => true],
            ['namamenu' => 'Es Jeruk', 'harga' => 8000, 'aktif' => true],
            ['namamenu' => 'Jus Alpukat', 'harga' => 12000, 'aktif' => true],
            ['namamenu' => 'Air Mineral', 'harga' => 3000, 'aktif' => true],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }

        // Seed Pelanggan
        $pelanggans = [
            ['namapelanggan' => 'John Doe', 'jeniskelamin' => true, 'noip' => '081234567890', 'alamat' => 'Jl. Sudirman No. 123'],
            ['namapelanggan' => 'Jane Smith', 'jeniskelamin' => false, 'noip' => '081234567891', 'alamat' => 'Jl. Thamrin No. 456'],
            ['namapelanggan' => 'Ahmad Rahman', 'jeniskelamin' => true, 'noip' => '081234567892', 'alamat' => 'Jl. Gatot Subroto No. 789'],
            ['namapelanggan' => 'Siti Nurhaliza', 'jeniskelamin' => false, 'noip' => '081234567893', 'alamat' => 'Jl. Kebon Jeruk No. 321'],
            ['namapelanggan' => 'Budi Santoso', 'jeniskelamin' => true, 'noip' => '081234567894', 'alamat' => 'Jl. Senayan No. 654'],
        ];

        foreach ($pelanggans as $pelanggan) {
            Pelanggan::create($pelanggan);
        }
    }
}