<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'tanggal',
        'keranjang_id',
        'nota',
        'laporan',
        'bukti_pelunasan',
        'pengiriman_id',
        'status',
        'alasan',
        'jenis_transaksi',
        'transaksi_id',
        'pendapatan_kotor',
        'pendapatan_bersih'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'status' => 'string',
        'jenis_transaksi' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pengiriman()
    {
        return $this->belongsTo(Pengiriman::class, 'pengiriman_id');
    }

    public function keranjang()
    {
        return $this->belongsTo(Pesanan::class, 'keranjang_id');
    }
}
