<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Walikelas extends Model
{
    protected $table = 'walikelas'; // Pastikan tabel ini sesuai dengan migrasi
    protected $primaryKey = 'id_walikelas'; // Pastikan primary key adalah id_walikelas
    protected $fillable = [
        'nama_walikelas',
        'nip',
        'jenis_kelamin',
        'alamat',
    ];
}
