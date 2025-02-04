<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarKaryawan extends Model
{
    use HasFactory;

    protected $table = 'daftar_karyawan';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'karyawan_id',
        'gaji_tambahan',
        'lembur_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    public function lembur()
    {
        return $this->belongsTo(Lembur::class, 'lembur_id');
    }
}
