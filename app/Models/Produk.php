<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'nama',
        'foto',
        'deskripsi',
        'isi',
        'satuan',
        'harga',
        'biaya_sales',
        'stok_id',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function stok()
    {
        return $this->belongsTo(Stok::class, 'stok_id');
    }
}
