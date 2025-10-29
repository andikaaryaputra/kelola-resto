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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id('idpesanan');
            $table->unsignedBigInteger('idmeja');
            $table->unsignedBigInteger('iduser_waiter');
            $table->unsignedBigInteger('idpelanggan');
            $table->enum('status', ['pending','proses','selesai','lunas'])->default('pending');
            $table->decimal('total', 12, 2)->default(0);

            $table->foreign('idmeja')->references('idmeja')->on('mejas')->onDelete('cascade');
            $table->foreign('iduser_waiter')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idpelanggan')->references('idpelanggan')->on('pelanggan')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
