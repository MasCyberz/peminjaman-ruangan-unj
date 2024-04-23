<?php

namespace App\Models;

use Egulias\EmailValidator\Result\Reason\DetailedReason;
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
        'jml_hari',
        'file_surat',
        'status',
        'alasan_penolakan'
    ];


    public function ruangans()
    {
        return $this->belongsToMany(ruangan::class, 'ruang_peminjaman', 'surat_id', 'ruangans_id')
        ->withPivot('status', 'tanggal_peminjaman');
    }

    public function detailPeminjaman(){
        return $this->hasMany(DetailPeminjaman::class, 'surat_id', 'id');
    }
}
