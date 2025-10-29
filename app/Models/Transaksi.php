<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';
    protected $primaryKey = 'idtransaksi';
    protected $fillable = [
        'idpesanan',
        'idkasir',
        'total',
        'bayar',
        'kembali',
        'metode_pembayaran'
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'bayar' => 'decimal:2',
        'kembali' => 'decimal:2'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'idpesanan');
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'idkasir');
    }
}