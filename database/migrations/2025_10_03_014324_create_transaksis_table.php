<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id('idtransaksi');
            $table->unsignedBigInteger('idpesanan');
            $table->unsignedBigInteger('idkasir');
            $table->decimal('total', 12, 2);
            $table->decimal('bayar', 12, 2);
            $table->decimal('kembali', 12,2);
            $table->string('metode_pembayaran', 20)->nullable();
            $table->timestamps();

            $table->foreign('idpesanan')->references('idpesanan')->on('pesanans')->onDelete('cascade');
            $table->foreign('idkasir')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
