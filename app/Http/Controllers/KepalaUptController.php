<?php

namespace App\Http\Controllers;

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
        $surat = surat::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // dd($surat);


        return view('kepala-upt.surat.surat-pengajuan',  ['suratList' => $surat]);
    }

    public function show_peminjaman($id)
    {
        $pengajuan = surat::FindOrFail($id);

        return view('kepala-upt.surat.surat-pengajuan-detail', ['pengajuanList' => $pengajuan]);
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

    public function kalender()
    {

        $ruangPeminjaman = RuangPeminjaman::select('ruang_peminjaman.*', 'ruangans.nomor_ruang')
            ->join('ruangans', 'ruang_peminjaman.ruangans_id', '=', 'ruangans.id')
            ->whereIn('ruang_peminjaman.status', ['pending', 'diterima'])
            ->get();

        $warna = ['red', 'blue', 'green', 'yellow', 'orange'];

        $events = [];

        $indeks = 0;

        foreach ($ruangPeminjaman as $ruang) {
            // 'start' => Carbon::parse($ruang->mulai_dipinjam)->format('Y-m-d'), // Sesuaikan format tanggal mulai
            // 'end' => Carbon::parse($ruang->selesai_dipinjam)->format('Y-m-d'), // Sesuaikan format tanggal selesai
            $start = Carbon::parse($ruang->mulai_dipinjam);
            $end = Carbon::parse($ruang->selesai_dipinjam);

            // menghitung durasi berapa lama
            $duration = $end->diffInDays($start);
            $end->addDay();


            $title = $ruang->nomor_ruang ? ' Ruang ' . $ruang->nomor_ruang : 'Peminjaman Ruang Tidak Diketahui';

            // memasukkan data ke array
            $events[] = [
                'title' => $title,
                'start' => $start->format('Y-m-d'),
                'end' => $end->format('Y-m-d'),
                'color' => $warna[$indeks],
            ];

            $indeks = ($indeks + 1) % count($warna);
        }

        return view('kepala-upt.kalender.kalender', compact('events'));
    }

    public function cobaFullCalendar()
    {
        // $ruangPeminjaman = RuangPeminjaman::get();
        // $events = [];
        // foreach ($ruangPeminjaman as $ruang) {
        //         // 'start' => Carbon::parse($ruang->mulai_dipinjam)->format('Y-m-d'), // Sesuaikan format tanggal mulai
        //         // 'end' => Carbon::parse($ruang->selesai_dipinjam)->format('Y-m-d'), // Sesuaikan format tanggal selesai
        //         $start = Carbon::parse($ruang->mulai_dipinjam);
        //         $end = Carbon::parse($ruang->selesai_dipinjam);

        //         // menghitung durasi berapa lama
        //         $duration = $end->diffInDays($start);
        //         $end->addDays($duration);

        //         // memasukkan data ke array
        //         $events[] = [
        //             'title' => 'nomor ruang',
        //             'start' => $start->format('Y-m-d'),
        //             'end' => $end->format('Y-m-d'),
        //             'color' => 'red',
        //         ];
        // }
        // return view('kepala-upt.surat.surat-pengajuan', compact('events'));
    }
}
