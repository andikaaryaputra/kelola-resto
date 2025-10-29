<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananDetail extends Model
{
    use HasFactory;

    protected $table = 'pesanan_details';
    protected $primaryKey = 'iddetail';
    protected $fillable = [
        'idpesanan',
        'idmenu',
        'jumlah',
        'harga',
        'subtotal',
        'status_item'
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'harga' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'idpesanan');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'idmenu');
    }
}