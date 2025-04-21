<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_lengkap',
        'nisn',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'kelas_id'
    ];

    // Relasi dengan kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id_kelas');
    }

    public function kasus()
    {
        return $this->hasMany(Kasus::class, 'siswa_id'); // Foreign key harus 'siswa_id'
    }
}
