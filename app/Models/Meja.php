<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    protected $table = 'mejas';
    protected $primaryKey = 'idmeja';
    public $incrementing = true;
    public $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'nomormeja',
        'kapasitas',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'idmeja';
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'idmeja');
    }
}
