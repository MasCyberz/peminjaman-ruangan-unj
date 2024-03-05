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

    /**
     * Get the user that owns the ruangan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fasilitas()
    {
        return $this->hasMany(fasilitas::class, 'ruangans_id', 'id');
    }
}
