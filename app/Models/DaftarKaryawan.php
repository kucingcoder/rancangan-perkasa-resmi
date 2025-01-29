<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarKaryawan extends Model
{
    use HasFactory;

    protected $table = 'daftar_karyawan';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['karyawan_id', 'lembur_id'];
}