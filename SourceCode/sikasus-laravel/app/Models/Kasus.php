<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kasus extends Model
{

    protected $table = 'kasus';
    protected $primaryKey = 'id_kasus';
    protected $fillable = ['deskripsi_kasus', 'tanggal_kasus', 'siswa_id'];



    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id');
    }

    protected $casts = [
        'tanggal_kasus' => 'date', // Mengubah tanggal_kasus menjadi objek Carbon
    ];
}
