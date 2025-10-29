<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';
    protected $primaryKey = 'idmenu';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'namamenu',
        'harga',
        'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'harga' => 'decimal:2'
    ];

    public function pesananDetails()
    {
        return $this->hasMany(PesananDetail::class, 'idmenu');
    }
}