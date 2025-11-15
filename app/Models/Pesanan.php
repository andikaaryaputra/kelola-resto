<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanans';
    protected $primaryKey = 'idpesanan';
    protected $fillable = ['idmeja', 'iduser_waiter', 'idpelanggan', 'status', 'total'];

    // Relasi
    public function meja()
    {
        return $this->belongsTo(Meja::class, 'idmeja','idmeja');
    }

    public function waiter()
    {
        return $this->belongsTo(User::class, 'iduser_waiter');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'idpelanggan', 'idpelanggan');
    }

    public function detail()
    {
        return $this->hasMany(PesananDetail::class, 'idpesanan');
    }

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'idpesanan');
    }
}
