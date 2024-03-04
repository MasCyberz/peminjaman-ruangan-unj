<?php

namespace Database\Seeders;

use App\Models\surat;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $data = [
        //     [
        //         'nomor_surat' => 'SPp/001/02/2024',
        //         'asal_surat' => 'Universitas Pencari Kerja',
        //         'nama_peminjam' => 'Surya',
        //         'mulai_dipinjam' => now(),
        //         'selesai_dipinjam' => now()->addDays(28),
        //         'jml_ruang' => 2,
        //         'jml_pc' => 12,
        //         'file_surat' => 'Surat_resmi_Universitas_Pencari_Kerja.pdf',
        //     ],
        //     [
        //         'nomor_surat' => 'SPp/002/02/2024',
        //         'asal_surat' => 'Universitas Pencari Cinta',
        //         'nama_peminjam' => 'Robin',
        //         'mulai_dipinjam' => now(),
        //         'selesai_dipinjam' => now()->addDays(29),
        //         'jml_ruang' => 5,
        //         'jml_pc' => 20,
        //         'file_surat' => 'Surat_resmi_Universitas_Pencari_Cinta.pdf',
        //     ],
        // ];

        // foreach ($data as $peminjamanData) {
        //     surat::create($peminjamanData);
        // }

        surat::factory()->count(100)->create();
    }
}
