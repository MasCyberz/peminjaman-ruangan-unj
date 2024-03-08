<?php

namespace App\Http\Controllers;

use App\Models\RuangPeminjaman;
use App\Models\surat;
use App\Models\ruangan;
use App\Models\fasilitas;
use Illuminate\Http\Request;

class KoordinatorController extends Controller
{

    public function index()
    {
        return view('koordinator.surat.index');
    }

    public function pengajuan()
    {

        $permintaanRuang = surat::with('ruangans')->whereHas('ruangans', function ($query) {
            $query->where('ruang_peminjaman.status', 'pending');
        })->get();

        return view('koordinator.surat.pengajuan-koordinator', ['permintaanRuang' => $permintaanRuang]);
    }

    public function pengajuan_store(Request $request, $suratId)
    {
        // $peminjaman = RuangPeminjaman::where('surat_id', $suratId)
        // ->where('ruangans_id', $ruanganId)
        // ->firstorFail();


        // $peminjaman->status = $request->status;
        // $peminjaman->save();

        // return redirect()->route('pengajuan_koordinator')->with('success', 'Pengajuan ruangan berhasil.');

        $status = $request->status; // 'approved' atau 'rejected'
        $surat = Surat::findOrFail($suratId);

        // Update status semua ruangan yang terkait dengan surat
        foreach ($surat->ruangans as $ruangan) {
            $surat->ruangans()->updateExistingPivot($ruangan->id, ['status' => $status]);
        }

        return back()->with('success', 'Semua ruangan untuk surat ini telah ' . ($status == 'approved' ? 'diterima' : 'ditolak') . '.');
    }

    public function data_referensi()
    {
        $ruangan = ruangan::with('fasilitas')->get();
        $fasilitas = fasilitas::get();
        return view('koordinator.surat.data_referensi-koordinator', ['ruanganList' => $ruangan, 'fasilitasList' => $fasilitas]);
    }
}
