<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TanggalPeminjaman extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = ['surat_id', 'tanggal_peminjaman', 'jml_ruang', 'jml_pc'];

    public function surat(){
        return $this->belongsTo(surat::class, 'surat_id');
    }
}
