<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'keranjang';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'judul',
        'akun_id',
        'pembeli_id',
    ];

    protected $casts = [
        'id' => 'string',
        'akun_id' => 'string',
        'pembeli_id' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'akun_id', 'id');
    }

    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class, 'pembeli_id', 'id');
    }
}
