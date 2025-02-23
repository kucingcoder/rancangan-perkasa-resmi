<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pesanan';
    protected $primaryKey = 'id';
    public $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'keranjang_id',
        'pengiriman_id',
        'jenis_transaksi',
        'id_transaksi',
        'pendapatan',
        'biaya_sales',
        'biaya_pengiriman',
        'kode_invoice',
        'bukti_pelunasan',
        'nota_pembeli',
        'nota_kurir',
        'laporan_sales',
        'laporan_internal',
        'status',
        'alasan_ditolak',
    ];

    protected $casts = [
        'jenis_transaksi' => 'string',
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pengiriman()
    {
        return $this->belongsTo(Pengiriman::class, 'pengiriman_id');
    }

    public function keranjang()
    {
        return $this->belongsTo(Keranjang::class, 'keranjang_id');
    }
}
