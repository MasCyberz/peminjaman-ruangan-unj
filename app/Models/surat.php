<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class surat extends Model
{
    use HasFactory;

    protected $table = 'surat';

    protected $fillable = [
        'nomor_surat',
        'asal_surat',
        'nama_peminjam',
        'mulai_dipinjam',
        'selesai_dipinjam',
        'jml_ruang',
        'jml_pc',
        'file_surat',
    ];


    public function ruangans()
    {
        return $this->belongsToMany(ruangan::class, 'ruang_peminjaman', 'surat_id', 'ruangans_id')
        ->withPivot('status');
    }
}
