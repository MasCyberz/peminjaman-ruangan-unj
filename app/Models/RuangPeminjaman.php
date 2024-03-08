<?php

namespace App\Models;

use App\Models\surat;
use App\Models\ruangan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RuangPeminjaman extends Model
{
    use HasFactory;
    protected $table = 'ruang_peminjaman';

    protected $fillable = [
        'surat_id',
        'ruangans_id',
        'mulai_dipinjam',
        'selesai_dipinjam',
    ];
}
