<?php

namespace App\Http\Controllers;

use App\Models\surat;
use App\Models\ruangan;
use App\Models\fasilitas;
use Illuminate\Http\Request;
use App\Models\RuangPeminjaman;
use App\Models\DetailPeminjaman;
use Illuminate\Validation\Validator;
use Illuminate\Auth\Events\Validated;

class JaringanController extends Controller
{
    public function index()
    {
        // Ambil semua ID surat yang sedang dalam proses peminjaman
        $suratIdsPending = RuangPeminjaman::pluck('surat_id')->toArray();

        // Hitung jumlah surat yang telah diterima dan belum dalam proses peminjaman
        $surat = surat::where('status', 'diterima')
            ->whereNotIn('id', $suratIdsPending)->count();

        $suratDitolakKoordinator = Surat::whereHas('ruangans', function ($query) {
            $query->where('ruang_peminjaman.status', 'ditolak koordinator');
        })->count();

        $totalSurat = $surat + $suratDitolakKoordinator;

        // Kirim hasil hitungan ke tampilan
        return view('jaringan.surat.index', ['pengajuan' => $totalSurat]);
    }

    public function table_peminjaman(Request $request)
    {
        // Ambil isi yang ada di ruangan
        $ruangan = Ruangan::get();

        // // Ambil semua ID surat yang sedang dalam proses peminjaman
        $suratIdsPending = RuangPeminjaman::pluck('surat_id')->toArray();
        $peminjamanStatus = [];
        // Query status peminjaman untuk setiap surat dalam $suratIdsPending
        foreach ($suratIdsPending as $suratId) {
            // Ambil status peminjaman
            $status = RuangPeminjaman::where('surat_id', $suratId)->value('status');
            // Simpan status dalam array
            $peminjamanStatus[$suratId] = $status;
        }

        // Ambil kata kunci pencarian dari form
        $limit = $request->input('numero', 10);

        $suratSelesai = RuangPeminjaman::pluck('surat_id');

        // Mengambil dengan status surat = diterima
        $surat = surat::where(function ($query) use ($request) {
            $query->where('status', 'diterima')
                ->orWhereHas('ruangans', function ($query) {
                    $query->where('ruang_peminjaman.status', 'ditolak koordinator');
                });
        })
            ->where(function ($query) use ($request) {
                $query->where('nomor_surat', 'like', '%' . $request->keyword . '%')
                    ->orWhere('asal_surat', 'like', '%' . $request->keyword . '%');
            });
        if (!empty($suratIdsPending)) {
            $surat->orderByRaw("FIELD(id, " . implode(',', $suratIdsPending) . ") ASC, created_at ASC");
        } else {
            $surat->orderBy('created_at', 'ASC');
        }

        $surat = $surat->paginate($limit);
        return view('jaringan.surat.peminjaman-jaringan', [
            'suratList' => $surat,
            'numero' => $request->input('numero'),
            'peminjaman' => $suratIdsPending,
            'suratSelesai' => $suratSelesai,
            'peminjamanStatus' => $peminjamanStatus, // Mengirim status peminjaman ke view
            // 'ruanganList' => $ruanganTersedia,
            // 'ruanganList' => $ruangan,
        ]);
    }

    public function data_referensi()
    {
        $ruangan = ruangan::with('fasilitas')->get();
        $fasilitas = fasilitas::get();
        return view('jaringan.surat.data-referensi', ['ruanganList' => $ruangan, 'fasilitasList' => $fasilitas]);
    }

    // public function show_detail($id)
    // {
    //     $surat = surat::with('detailPeminjaman')->FindOrFail($id);
    //     return view('jaringan.surat.detail-surat-peminjaman', ['suratList' => $surat]);
    // }

    public function show_detail($id)
    {
        $surat = surat::with(['detailPeminjaman', 'ruangans' => function ($query) {
            $query->select('ruangans_id', 'surat_id', 'nomor_ruang')->withPivot('status');
        }])->FindOrFail($id);

        // Mendapatkan status peminjaman dari pivot table
        $peminjamanStatus = $surat->ruangans->pluck('pivot.status', 'id');

        return view('jaringan.surat.detail-surat-peminjaman', ['suratList' => $surat, 'peminjamanStatus' => $peminjamanStatus]);
    }

    public function ajukanPeminjaman($surat_id)
    {
        $surat = surat::with('detailPeminjaman')->FindOrFail($surat_id);
        $ruanganTersedia = Ruangan::get();
        // dd($surat);

        // Tanggal peminjaman yang sudah ada untuk setiap ruangan
        $tanggalPeminjamanRuangan = [];

        // Ambil tanggal peminjaman ruangan yang sudah ada
        foreach ($ruanganTersedia as $ruangan) {
            $tanggalPeminjamanRuangan[$ruangan->id] = RuangPeminjaman::where('ruangans_id', $ruangan->id)
                ->where('tanggal_peminjaman', $surat->detailPeminjaman->pluck('tanggal_peminjaman')->toArray())
                ->pluck('tanggal_peminjaman')
                ->toArray();
        }

        // Filter ruangan yang belum dipinjam pada tanggal yang diminta
        $ruanganTersedia = $ruanganTersedia->filter(function ($ruangan) use ($tanggalPeminjamanRuangan) {
            return empty($tanggalPeminjamanRuangan[$ruangan->id]);
        });

        return view('jaringan.surat.ajukan-peminjaman', ['suratList' => $surat, 'ruanganTersedia' => $ruanganTersedia]);
    }

    public function ajukanPeminjamanStore(Request $request, $suratId)
    {
        // // Validasi data yang diterima
        // $validatedData = $request->validate([
        //     'tanggal_peminjaman' => 'array',
        //     'tanggal_peminjaman.*' => 'date',
        //     'ruangan' => 'required|array',
        //     'ruangan.*' => 'required|exists:ruangans,id',
        // ], [
        //     'required' => ' :attribute harus diisi',
        // ]);

        // // Mencari surat dengan ID yang diberikan
        // $surat = Surat::with('detailPeminjaman')->findOrFail($suratId);

        // // Periksa jadwal ruangan untuk setiap ruangan yang dipilih
        // foreach ($validatedData['ruangan'] as $ruanganId) {
        //     foreach ($surat->detailPeminjaman as $detailPeminjaman) {
        //         // Periksa apakah ruangan pernah ditolak untuk setiap tanggal peminjaman
        //         $ruanganDitolak = RuangPeminjaman::where('ruangans_id', $ruanganId)
        //             ->whereIn('status', ['pending', 'diterima'])
        //             ->where('tanggal_peminjaman', $detailPeminjaman->tanggal_peminjaman)
        //             ->exists();

        //         if ($ruanganDitolak) {
        //             $ruangan = Ruangan::find($ruanganId);
        //             return back()->withErrors(['ruangan' => 'Ruangan dengan nomor ' . $ruangan->nomor_ruang . ' sudah dipinjam pada jadwal yang dipilih.']);
        //         }
        //     }
        // }

        // foreach ($validatedData['ruangan'] as $ruanganId) {
        //     foreach ($surat->detailPeminjaman as $detailPeminjaman) {
        //         $surat->ruangans()->syncWithoutDetaching([
        //             $ruanganId => ['tanggal_peminjaman' => $detailPeminjaman->tanggal_peminjaman],
        //         ]);
        //     }
        // }
        // Validasi data yang dikirimkan

        // $validatedData = $request->validate([
        //     'ruangan.*' => 'required|exists:ruangans,id',
        //     'ruangan' => 'array',
        //     'tanggal_peminjaman.*' => 'required|date',
        // ]);

        // foreach ($request->tanggal_peminjaman as $index => $tanggal_peminjaman) {
        //     $ruanganIds = $request->ruangan[$index];
        //     $detailPeminjaman = DetailPeminjaman::where('tanggal_peminjaman', $tanggal_peminjaman)->first();

        //     if (!$detailPeminjaman) {
        //         // Handle jika detail peminjaman tidak ditemukan
        //         return redirect()->back()->withErrors('Detail peminjaman tidak ditemukan untuk tanggal ini.');
        //     }

        //     $jumlah_ruangan_diminta = $detailPeminjaman->jml_ruang; // Ambil jumlah ruangan yang diminta dari tabel detail_peminjaman

        //     $totalRuanganDipinjam = count($ruanganIds); // Menghitung jumlah ruangan yang dipinjam

        //     if ($totalRuanganDipinjam !== $jumlah_ruangan_diminta) {
        //         // Jumlah ruangan yang dipinjam tidak sesuai dengan jumlah yang diminta untuk tanggal ini
        //         return redirect()->back()->withErrors('Jumlah ruangan yang dipilih tidak sesuai dengan jumlah ruang yang diperlukan untuk surat ini pada tanggal ' . $tanggal_peminjaman . '.');
        //     }

        //     foreach ($ruanganIds as $ruanganId) {
        //         $ruangPeminjaman = new RuangPeminjaman();
        //         $ruangPeminjaman->surat_id = $suratId; // Sesuaikan dengan nama input yang sesuai
        //         $ruangPeminjaman->ruangans_id = $ruanganId;
        //         $ruangPeminjaman->tanggal_peminjaman = $tanggal_peminjaman;
        //         $ruangPeminjaman->save();
        //     }
        // }

        $request->validate([
            'ruangan' => 'required|array',
            'ruangan.*' => 'required|array',
            'ruangan.*.*' => 'required|exists:ruangans,id', // Pastikan ruangan yang dipilih ada dalam database
        ]);

        $ruangan = $request->ruangan;
        $surat = Surat::findOrFail($suratId);

        foreach ($ruangan as $tanggal => $ruangans) {
            // Cek apakah surat memiliki detail peminjaman pada tanggal tertentu
            $detailPeminjaman = $surat->detailPeminjaman()->where('tanggal_peminjaman', $tanggal)->first();

            if ($detailPeminjaman) {
                // Validasi jumlah ruangan yang dipilih
                if (count($ruangans) != $detailPeminjaman->jml_ruang) {
                    return back()->withErrors('Jumlah ruang yang dipilih tidak sesuai dengan yang dibutuhkan surat.');
                }

                // Proses penyimpanan ruangan ke tabel pivot
                foreach ($ruangans as $ruanganId) {
                    $surat->ruangans()->attach($ruanganId, ['tanggal_peminjaman' => $tanggal]);
                }
            } else {
                return redirect()->back()->withErrors('Detail peminjaman tidak ditemukan untuk tanggal ini.');
            }
        }

        // Mengembalikan ke Tampilan
        return redirect()->route('peminjaman_jaringan')->with('success', 'Peminjaman ruangan berhasil diajukan.');
    }

    public function terimaTolakanKoordinator(Request $request, $suratId)
    {
        $surat = Surat::findOrFail($suratId);

        // Ambil semua ruangan yang terkait dengan surat
        $ruangans = $surat->ruangans;

        // Ubah status pada pivot tabel ruang_peminjaman menjadi 'jaringan menerima tolakan koordinator'
        foreach ($ruangans as $ruangan) {
            $surat->ruangans()->updateExistingPivot($ruangan->id, ['status' => 'jaringan menerima tolakan koordinator']);
        }

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Status tolakan koordinator berhasil diterima.');
    }

    
}
