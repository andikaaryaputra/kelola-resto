<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("
            DROP PROCEDURE IF EXISTS LaporanTransaksiHarian;
        ");

        DB::unprepared("
            CREATE PROCEDURE LaporanTransaksiHarian(IN tanggalInput DATE)
            BEGIN
                SELECT 
                    t.idtransaksi,
                    t.created_at AS created_at,
                    t.total AS total,
                    p.idpesanan,
                    p.total AS total_pesanan,
                    p.status,
                    p.idmeja,
                    p.iduser_waiter,
                    p.idpelanggan,
                    t.bayar,
                    t.kembali,
                    t.metode_pembayaran
                FROM transaksis t
                LEFT JOIN pesanans p 
                    ON p.idpesanan = t.idpesanan
                WHERE DATE(t.created_at) = tanggalInput;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS LaporanTransaksiHarian;");
    }
};
