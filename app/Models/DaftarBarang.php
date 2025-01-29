<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarBarang extends Model
{
    use HasFactory;

    protected $table = 'daftar_barang';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['barang_id', 'keranjang_id', 'jumlah'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }

    public function pesanan()
    {
        return $this->belongsTo(Keranjang::class, 'keranjang_id', 'id');
    }
}