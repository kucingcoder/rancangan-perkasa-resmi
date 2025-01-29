<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembeli extends Model
{
    use HasFactory;

    protected $table = 'pembeli';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['nama', 'alamat', 'no_wa', 'email'];

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'pembeli_id', 'id');
    }
}