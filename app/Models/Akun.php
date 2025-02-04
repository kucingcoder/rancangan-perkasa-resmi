<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Akun extends Model
{
    use HasUuids;

    protected $table = 'akun';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'email',
        'no_wa',
        'password',
        'nama',
        'foto',
        'jenis_kelamin',
        'alamat',
        'jenis_akun',
        'status',
    ];

    protected $casts = [
        'jenis_kelamin' => 'string',
        'jenis_akun' => 'string',
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $hidden = [
        'password',
    ];
}
