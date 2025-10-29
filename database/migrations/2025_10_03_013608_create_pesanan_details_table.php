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
        Schema::create('pesanan_details', function (Blueprint $table) {
            $table->id('iddetail');
            $table->unsignedBigInteger('idpesanan');
            $table->unsignedBigInteger('idmenu');
            $table->integer('jumlah');
            $table->decimal('harga', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->enum('status_item', ['ORDERED','SERVED'])->default('ORDERED');

            $table->foreign('idpesanan')->references('idpesanan')->on('pesanans')->onDelete('cascade');
            $table->foreign('idmenu')->references('idmenu')->on('menus')->onDelete('cascade');

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_details');
    }
};
