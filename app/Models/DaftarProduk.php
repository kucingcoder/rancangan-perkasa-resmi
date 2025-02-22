<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarProduk extends Model
{
    use HasFactory;

    protected $table = 'daftar_produk';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'produk_id',
        'keranjang_id',
        'jumlah'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function keranjang()
    {
        return $this->belongsTo(Keranjang::class, 'keranjang_id');
    }
}
