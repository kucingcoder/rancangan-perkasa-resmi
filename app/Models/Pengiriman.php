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
        'ekspedisi_id',
        'biaya_kirim_id',
        'alamat_tujuan',
        'jumlah_pengiriman',
        'foto_bukti'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function ekspedisi()
    {
        return $this->belongsTo(Ekspedisi::class, 'ekspedisi_id');
    }

    public function biaya_kirim()
    {
        return $this->belongsTo(BiayaKirim::class, 'biaya_kirim_id');
    }
}
