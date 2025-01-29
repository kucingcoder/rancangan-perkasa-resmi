<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['judul', 'akun_id, pembeli_id'];

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'akun_id', 'id');
    }

    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class, 'pembeli_id', 'id');
    }
}