<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'idpelanggan';
    protected $fillable = [
        'namapelanggan',
        'jeniskelamin',
        'noip',
        'alamat',
    ];

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'idpelanggan');
    }
}
