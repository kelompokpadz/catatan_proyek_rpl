<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    // Karena nama tabel kita 'proyek' (bukan 'proyeks'), kita wajib definisikan ini
    protected $table = 'proyek';

    // Field yang boleh diisi secara massal
    protected $fillable = [
        'user_id',
        'nama_proyek',
        'jenis_proyek',
        'teknologi',
        'deskripsi',
        'status_proyek',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    // Relasi: Proyek dimiliki oleh satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}