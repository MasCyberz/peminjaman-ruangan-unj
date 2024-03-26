<?php

namespace App\Http\Controllers;

use App\Models\surat;
use App\Models\ruangan;
use Illuminate\Http\Request;
use App\Models\fasilitas;
use App\Models\RuangPeminjaman;
use Psy\Command\WhereamiCommand;

class JaringanController extends Controller
{
    public function index()
    {
        // Ambil semua ID surat yang sedang dalam proses peminjaman
        $suratIdsPending = RuangPeminjaman::pluck('surat_id')->toArray();

        // Hitung jumlah surat yang telah diterima dan belum dalam proses peminjaman
        $surat = surat::where('status', 'diterima')
            ->whereNotIn('id', $suratIdsPending)->count();

        // Kirim hasil hitungan ke tampilan
        return view('jaringan.surat.index', ['pengajuan' => $surat]);
    }

    public function table_peminjaman(Request $request)
    {
        // Ambil isi yang ada di ruangan
        $ruangan = Ruangan::get();

        // Ambil semua ID surat yang sedang dalam proses peminjaman
        $suratIdsPending = RuangPeminjaman::pluck('surat_id')->toArray();

        // Ambil ruangan-ruangan yang tersedia (tidak ada dalam ruang_peminjaman) jika filter digunakan
        if ($request->has('mulai_dipinjam') && $request->has('selesai_dipinjam')) {
            $ruanganTersedia = Ruangan::whereNotIn('id', function ($query) use ($request) {
                $query->select('ruangans_id')
                    ->from('ruang_peminjaman')
                    ->where(function ($query) use ($request) {
                        $query->whereBetween('mulai_dipinjam', [$request->mulai_dipinjam, $request->selesai_dipinjam])
                            ->orWhereBetween('selesai_dipinjam', [$request->mulai_dipinjam, $request->selesai_dipinjam]);
                    })
                    ->where('status', '!=', 'ditolak'); // Hanya ambil yang bukan 'ditolak'
            })
                ->get();
        } else {
            // Jika tidak ada filter yang digunakan, tampilkan semua ruangan
            $ruanganTersedia = $ruangan;
        }

        // Ambil kata kunci pencarian dari form
        $limit = $request->input('numero', 10);
        // Mengambil dengan status surat = diterima
        $surat = surat::where('status', 'diterima')
            ->whereNotIn('id', $suratIdsPending)
            ->where(function ($query) use ($request) {
                $query->where('nomor_surat', 'like', '%' . $request->keyword . '%')
                    ->orWhere('asal_surat', 'like', '%' . $request->keyword . '%');
            })
            ->orderby('created_at', 'asc')
            ->paginate($limit);
        return view('jaringan.surat.peminjaman-jaringan', [
            'suratList' => $surat,
            'numero' => $request->input('numero'),
            // 'ruanganList' => $ruangan,
            'peminjaman' => $suratIdsPending,
            'ruanganList' => $ruanganTersedia
        ]);
    }

    public function data_referensi()
    {
        $ruangan = ruangan::with('fasilitas')->get();
        $fasilitas = fasilitas::get();
        return view('jaringan.surat.data-referensi', ['ruanganList' => $ruangan, 'fasilitasList' => $fasilitas]);
    }

    public function show_detail($id)
    {
        $surat = surat::FindOrFail($id);
        return view('jaringan.surat.detail-surat-peminjaman', ['suratList' => $surat]);
    }

    public function ajukanPeminjaman($surat_id)
    {
        $surat = surat::FindOrFail($surat_id);
        $ruanganTersedia = Ruangan::where('status', 'tersedia')->get();
        // dd($surat);


        return view('jaringan.surat.ajukan-peminjaman', ['suratList' => $surat, 'ruanganTersedia' => $ruanganTersedia]);
    }

    public function ajukanPeminjamanStore(Request $request, $suratId)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'nomor_surat' => 'required',
            'asal_surat' => 'required',
            'ruangan' => 'required|array',
            'ruangan.*' => 'required|distinct|exists:ruangans,id',
        ], [
            'required' => ' :attribute harus diisi',
        ]);

        // Mencari surat dengan ID yang diberikan
        $surat = Surat::findOrFail($suratId);

        // Cek apakah jumlah ruang yang dipilih sesuai oleh surat
        $jml_ruang_surat = $surat->jml_ruang;
        $jumlah_ruangan_dipilih = count($validatedData['ruangan']);
        if ($jml_ruang_surat != $jumlah_ruangan_dipilih) {
            return back()->withErrors(['ruangan' => 'Jumlah ruangan yang dipilih tidak sesuai dengan jumlah ruang yang diperlukan untuk surat ini.']);
        }

        // Periksa jadwal ruangan untuk setiap ruangan yang dipilih
        foreach ($validatedData['ruangan'] as $ruanganId) {
            // $ruangan = Ruangan::find($ruanganId);

            // // Permasalahan jadwal
            // $konflik = Ruangan::whereHas('surats', function ($query) use ($surat, $ruanganId) {
            //     $query->where('ruangans_id', $ruanganId)
            //         ->where(function ($query) use ($surat) {
            //             $query->whereBetween('ruang_peminjaman.mulai_dipinjam', [$surat->mulai_dipinjam, $surat->selesai_dipinjam])
            //                 ->orWhereBetween('ruang_peminjaman.selesai_dipinjam', [$surat->mulai_dipinjam, $surat->selesai_dipinjam]);
            //         });
            // })->exists();

            // Jika ada masalah pada ruangan dengan jadwal. Maka kembalikan dengan pesan kesalahan.
            // if ($konflik) {
            //     $konflikDitolak = RuangPeminjaman::where('ruangans_id', $ruanganId)
            //         ->where('status', 'ditolak')
            //         ->where(function ($query) use ($surat) {
            //             $query->whereBetween('mulai_dipinjam', [$surat->mulai_dipinjam, $surat->selesai_dipinjam])
            //                 ->orWhereBetween('selesai_dipinjam', [$surat->mulai_dipinjam, $surat->selesai_dipinjam]);
            //         })
            //         ->exists();

            //     if ($konflikDitolak) {
            //         return back()->withErrors(['ruangan' => 'Ruangan dengan nomor ' . $ruangan->nomor_ruang  . ' tidak tersedia pada jadwal yang dipilih.']);
            //     }
            // }

            // Periksa apakah ruangan pernah ditolak
            $ruanganDitolak = RuangPeminjaman::where('ruangans_id', $ruanganId)
                ->whereIn('status', ['pending', 'diterima']) // hanya memperhitungkan status pending dan diterima
                ->where(function ($query) use ($surat) {
                    $query->whereBetween('mulai_dipinjam', [$surat->mulai_dipinjam, $surat->selesai_dipinjam])
                        ->orWhereBetween('selesai_dipinjam', [$surat->mulai_dipinjam, $surat->selesai_dipinjam]);
                })
                ->exists();

            if ($ruanganDitolak) {
                // Tambahkan pesan kesalahan jika ruangan sudah dipinjam pada jadwal yang sama
                return back()->withErrors(['ruangan' => 'Ruangan dengan nomor ' . $ruanganId . ' sudah dipinjam pada jadwal yang dipilih.']);
            }

            // Simpan data peminjaman ruangan ke dalam database
            $surat->ruangans()->attach($ruanganId, [
                'mulai_dipinjam' => $surat->mulai_dipinjam,
                'selesai_dipinjam' => $surat->selesai_dipinjam
            ]);
        }

        // Mengembalikan ke Tampilan
        return redirect()->route('peminjaman_jaringan')->with('success', 'Peminjaman ruangan berhasil diajukan.');
    }
}
