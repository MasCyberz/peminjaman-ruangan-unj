<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fasilitas extends Model
{
    use HasFactory;

    protected $table = 'fasilitass';
    protected $fillable = [
        'id',
        'ruangans_id',
        'nama_fasilitas',
        'jumlah'
    ];

    /**
     * Get all of the comments for the fasilitas
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ruang()
    {
        return $this->belongsTo(ruangan::class);
    }
}
