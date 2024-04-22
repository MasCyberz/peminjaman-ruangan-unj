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

        // Kirim hasil hitungan ke tampilan
        return view('jaringan.surat.index', ['pengajuan' => $surat]);
    }

    public function table_peminjaman(Request $request)
    {
        // Ambil isi yang ada di ruangan
        $ruangan = Ruangan::get();

        // // Ambil semua ID surat yang sedang dalam proses peminjaman
        $suratIdsPending = RuangPeminjaman::pluck('surat_id')->toArray();

        // Ambil ruangan-ruangan yang tersedia (tidak ada dalam ruang_peminjaman) jika filter digunakan
        // if ($request->has('mulai_dipinjam') && $request->has('selesai_dipinjam')) {
        //     $ruanganTersedia = Ruangan::whereNotIn('id', function ($query) use ($request) {
        //         $query->select('ruangans_id')
        //             ->from('ruang_peminjaman')
        //             ->where(function ($query) use ($request) {
        //                 $query->whereBetween('mulai_dipinjam', [$request->mulai_dipinjam, $request->selesai_dipinjam])
        //                     ->orWhereBetween('selesai_dipinjam', [$request->mulai_dipinjam, $request->selesai_dipinjam]);
        //             })
        //             ->where('status', '!=', 'ditolak'); // Hanya ambil yang bukan 'ditolak'
        //     })
        //         ->get();
        // } else {
        //     // Jika tidak ada filter yang digunakan, tampilkan semua ruangan
        //     $ruanganTersedia = $ruangan;
        // }

        // Ambil kata kunci pencarian dari form
        $limit = $request->input('numero', 10);

        $suratSelesai = RuangPeminjaman::pluck('surat_id');

        // Mengambil dengan status surat = diterima
        $surat = surat::where('status', 'diterima')
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
            'suratSelesai' => $suratSelesai
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

    public function show_detail($id)
    {
        $surat = surat::with('detailPeminjaman')->FindOrFail($id);
        return view('jaringan.surat.detail-surat-peminjaman', ['suratList' => $surat]);
    }

    public function ajukanPeminjaman($surat_id)
    {
        $surat = surat::with('detailPeminjaman')->FindOrFail($surat_id);
        $ruanganTersedia = Ruangan::get();
        // dd($surat);

        // Tanggal peminjaman yang sudah ada untuk setiap ruangan
        $tanggalPeminjamanRuangan = [];

        // Ambil tanggal peminjaman ruangan yang sudah ada pada setiap ruangan
        foreach ($ruanganTersedia as $ruangan) {
            $tanggalPeminjamanRuangan[$ruangan->id] = RuangPeminjaman::where('ruangans_id', $ruangan->id)
                ->where('status', 'Disetujui') // hanya peminjaman yang sudah disetujui
                ->pluck('tanggal_peminjaman')
                ->toArray();
        }

        // Filter nomor ruangan yang belum dipinjam pada tanggal yang diminta
        $ruanganTersedia = $ruanganTersedia->filter(function ($ruangan) use ($tanggalPeminjamanRuangan) {
            // Ambil tanggal peminjaman ruangan pada ruangan tertentu
            $tanggalPeminjaman = $tanggalPeminjamanRuangan[$ruangan->id] ?? [];

            // Jika tidak ada tanggal peminjaman atau tidak ada tanggal yang cocok
            if (empty($tanggalPeminjaman)) {
                return true;
            }

            // Jika tanggal yang diminta tidak ada dalam tanggal peminjaman ruangan
            if (!in_array(request('tanggal_peminjaman'), $tanggalPeminjaman)) {
                return true;
            }

            return false;
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

        $validatedData = $request->validate([
            'ruangan.*' => 'required|exists:ruangans,id',
            'ruangan' => 'array',
            'tanggal_peminjaman.*' => 'required|date',
        ]);

        foreach ($request->tanggal_peminjaman as $index => $tanggal_peminjaman) {
            $ruanganIds = $request->ruangan[$tanggal_peminjaman];
            $totalRuanganDipinjam = count($ruanganIds); // Menghitung jumlah ruangan yang dipinjam

            $detailPeminjaman = DetailPeminjaman::where('tanggal_peminjaman', $tanggal_peminjaman)->first();
            $jumlah_ruangan_diminta = $detailPeminjaman->jml_ruang; // Mengambil jumlah ruangan yang diminta pada tanggal tertentu

            if ($totalRuanganDipinjam !== $jumlah_ruangan_diminta) {
                // Jumlah ruangan yang dipinjam tidak sesuai dengan yang diminta pada tanggal ini
                // Anda dapat menampilkan pesan error atau melakukan tindakan lain sesuai kebutuhan
                return redirect()->back()->withErrors('Jumlah ruangan yang dipilih tidak sesuai dengan jumlah ruang yang diperlukan untuk surat ini.');
            }

            foreach ($ruanganIds as $ruanganId) {
                $ruangPeminjaman = new RuangPeminjaman();
                $ruangPeminjaman->surat_id = $suratId; // sesuaikan dengan nama input yang sesuai
                $ruangPeminjaman->ruangans_id = $ruanganId;
                $ruangPeminjaman->tanggal_peminjaman = $tanggal_peminjaman;
                $ruangPeminjaman->save();
            }
        }
        // Mengembalikan ke Tampilan
        return redirect()->route('peminjaman_jaringan')->with('success', 'Peminjaman ruangan berhasil diajukan.');
    }
}
