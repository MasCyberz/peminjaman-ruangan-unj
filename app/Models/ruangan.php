<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ruangan extends Model
{
    use HasFactory;

    protected $table = 'ruangans';
    protected $guarded = ['id'];

    protected $fillable = [
        'nomor_ruang',
        'nama_ruang',
        'jml_pc',
        'kapasitas_orang',
        'gambar_ruang'
    ];

    public function cekKetersediaan($tanggalMulai, $tanggalSelesai)
    {
        $peminjaman = $this->surats()
            ->wherePivot('mulai_dipinjam', '<=', '$tanggalMulai')
            ->wherePivot('selesai_dipinjam', '>=', '$tanggalSelesai')
            ->exists();

        return $peminjaman ? 'tidak tersedia' : 'tersedia';
    }

    /**
     * Get the user that owns the ruangan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fasilitas()
    {
        return $this->hasMany(fasilitas::class, 'ruangans_id', 'id');
    }

    /**
     * The roles that belong to the ruangan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function surats()
    {
        return $this->belongsToMany(surat::class, 'ruang_peminjaman', 'ruangans_id', 'surat_id');
    }
}
