<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;

    protected $table = 'pengiriman';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'nama_kurir',
        'no_wa_kurir',
        'foto_kurir',
        'expedisi_id',
        'wilayah_id',
        'alamat',
        'jumlah',
        'foto_bukti'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function ekspedisi()
    {
        return $this->belongsTo(Ekspedisi::class, 'expedisi_id');
    }

    public function biayaPengiriman()
    {
        return $this->belongsTo(BiayaPengiriman::class, 'wilayah_id');
    }
}
