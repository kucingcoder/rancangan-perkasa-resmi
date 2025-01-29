<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;

    protected $table = 'pengiriman';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['nama_kurir', 'no_wa_kurir', 'foto_kurir', 'expedisi_id', 'wilayah_id', 'alamat', 'jumlah', 'foto_bukti'];

    public function expedisi()
    {
        return $this->belongsTo(Expedisi::class, 'expedisi_id', 'id');
    }

    public function wilayah()
    {
        return $this->belongsTo(BiayaPengiriman::class, 'wilayah_id', 'id');
    }
}