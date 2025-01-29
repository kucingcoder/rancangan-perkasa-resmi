<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['nama_kategori', 'ukuran', 'satuan', 'biaya_sales'];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'kategori_id', 'id');
    }
}