<?php

namespace App\Http\Controllers;

use App\Models\ruangan;
use Carbon\Carbon;
use App\Models\surat;
use Illuminate\Http\Request;
use App\Models\RuangPeminjaman;

class KepalaUptController extends Controller
{
    public function index()
    {
        $pengajuan = surat::select('status')->where('status', 'pending')->count();
        return view('kepala-upt.surat.index', ['pengajuan' => $pengajuan]);
    }

    public function peminjaman()
    {
        // Mengambil data dari table RuangPeminjaman. mengecek apakah surat_id ada atau tidak di table RuangPeminjaman
        $suratIdsPending = RuangPeminjaman::pluck('surat_id')->toArray();

        if (!empty($suratIdsPending)) {
            $surat = Surat::with('detailPeminjaman', 'ruangans')
                ->where(function ($query) use ($suratIdsPending) {
                    $query->whereIn('id', $suratIdsPending)
                        ->orWhereNotIn('id', $suratIdsPending); // Menambahkan kondisi untuk menampilkan semua surat jika tidak ada surat_id di RuangPeminjaman
                })
                ->orderByRaw("FIELD(id, " . implode(',', $suratIdsPending) . ") ASC, created_at ASC")
                ->paginate(15);
        } else {
            $surat = Surat::with('detailPeminjaman')
                ->orderBy('created_at', 'ASC')
                ->paginate(15);
        }

        return view('kepala-upt.surat.surat-pengajuan',  ['suratList' => $surat]);
    }

    public function show_peminjaman($id)
    {
        $pengajuan = surat::with('detailPeminjaman')->FindOrFail($id);

        if ($pengajuan) {
            return view('kepala-upt.surat.surat-pengajuan-detail', ['pengajuanList' => $pengajuan]);
        } else {
            abort(404);
        }
    }

    public function respond(Request $request, $id)
    {
        $surat = surat::FindOrFail($id);

        if ($request->response == 'accept') {
            $surat->status = 'diterima';
            $message = 'Surat berhasil diterima.';
        } elseif ($request->response == 'reject') {
            $surat->status = 'ditolak';
            $surat->alasan_penolakan = $request->alasan_penolakan;
            $message = 'Surat berhasil ditolak.';
        }

        $surat->save();
        return redirect('/kepala-upt/peminjaman')->with('success', $message);
    }

    public function terimaTolakanKoordinator(Request $request, $id)
    {

        $surat = Surat::findOrFail($id);

        if ($request->response == 'accept') {
            // Ambil semua ruangan yang terkait dengan surat
            $ruangans = $surat->ruangans;

            // Ubah status pada pivot tabel ruang_peminjaman
            foreach ($ruangans as $ruangan) {
                // Hapus ruangan yang dipinjam oleh surat dari pivot tabel
                $surat->ruangans()->updateExistingPivot($ruangan->id, ['status' => 'ka, jaringan, koordinator menolak surat ini']);
            }

            $surat->status = 'ditolak';
        }

        $surat->save();
        return redirect('/kepala-upt/peminjaman')->with('success', 'Berhasil menyetujui penolakan dari Koordinator dan Jaringan');
    }

    // public function kalender()
    // {

    //     // $ruangPeminjaman = RuangPeminjaman::select('ruang_peminjaman.*', 'ruangans.nomor_ruang')
    //     //     ->join('ruangans', 'ruang_peminjaman.ruangans_id', '=', 'ruangans.id')
    //     //     ->whereIn('ruang_peminjaman.status', ['pending', 'diterima'])
    //     //     ->get();

    //     $ruangPeminjaman = RuangPeminjaman::select('ruang_peminjaman.*', 'ruangans.nomor_ruang')
    //         ->join('ruangans', 'ruang_peminjaman.ruangans_id', '=', 'ruangans.id')
    //         ->where('ruang_peminjaman.status', 'diterima')
    //         ->get();


    //     $warna = ['red', 'blue', 'green', 'orange'];

    //     $events = [];

    //     $indeks = 0;

    //     foreach ($ruangPeminjaman as $ruang) {
    //         // 'start' => Carbon::parse($ruang->mulai_dipinjam)->format('Y-m-d'), // Sesuaikan format tanggal mulai
    //         // 'end' => Carbon::parse($ruang->selesai_dipinjam)->format('Y-m-d'), // Sesuaikan format tanggal selesai
    //         $tanggal = Carbon::parse($ruang->tanggal_peminjaman);

    //         // // menghitung durasi berapa lama
    //         // $duration = $end->diffInDays($start);
    //         // $end->addDay();


    //         $title = $ruang->nomor_ruang ? ' Ruang ' . $ruang->nomor_ruang : 'Peminjaman Ruang Tidak Diketahui';

    //         // memasukkan data ke array
    //         $events[] = [
    //             'title' => $title,
    //             'start' => $tanggal->format('Y-m-d'),
    //             'end' => $tanggal->format('Y-m-d'),
    //             'color' => $warna[$indeks],
    //         ];

    //         $indeks = ($indeks + 1) % count($warna);
    //     }

    //     return view('kepala-upt.kalender.kalender', compact('events'));
    // }

    public function kalender()
    {
        $events = [];
        $warna = ['red', 'green', 'blue', 'orange'];
        $indeks = 0;

        $ruangPeminjaman = RuangPeminjaman::select('ruang_peminjaman.*', 'ruangans.nomor_ruang')
            ->join('ruangans', 'ruang_peminjaman.ruangans_id', '=', 'ruangans.id')
            ->where('ruang_peminjaman.status', 'diterima')
            ->get();

        $totalRuangan = ruangan::count();
        // Membuat array asosiatif untuk menyimpan jumlah ruangan yang terpakai pada setiap tanggal
        $ruanganTerpakaiPerTanggal = [];

        foreach ($ruangPeminjaman as $ruang) {
            $tanggal = Carbon::parse($ruang->tanggal_peminjaman)->format('Y-m-d');

            // Menambahkan jumlah ruangan yang terpakai pada tanggal tersebut
            if (!isset($ruanganTerpakaiPerTanggal[$tanggal])) {
                $ruanganTerpakaiPerTanggal[$tanggal] = 1;
            } else {
                $ruanganTerpakaiPerTanggal[$tanggal]++;
            }
        }
        
        // Membuat event untuk setiap tanggal dengan judul berupa jumlah ruangan yang terpakai
        foreach ($ruanganTerpakaiPerTanggal as $tanggal => $jumlahRuangan) {
            $events[] = [
                'title' => 'Ruangan tersedia : ' . ($totalRuangan - $jumlahRuangan),
                'start' => $tanggal,
                'end' => $tanggal,
                'color' => $warna[$indeks % count($warna)],
            ];

            $indeks++;

        }
        return view('kepala-upt.kalender.kalender', compact('events'));
    }
}
