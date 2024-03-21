<?php

namespace App\Http\Controllers;

use App\Models\RuangPeminjaman;
use App\Models\surat;
use App\Models\ruangan;
use App\Models\fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KoordinatorController extends Controller
{

    public function index()
    {
        $permintaanRuang = surat::with('ruangans')->whereHas('ruangans', function ($query) {
            $query->where('ruang_peminjaman.status', 'pending');
        })->count();
        return view('koordinator.surat.index', ['permintaanRuang' => $permintaanRuang]);
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
        
        $status = $request->status; // 'approved' atau 'rejected'
        
        $surat = Surat::findOrFail($suratId);

        $fileToDelete = $surat->file_surat ; // Ganti dengan nama file yang ingin dihapus
        $path = 'public/file_surat/' . $fileToDelete;

        // Update status semua ruangan yang terkait dengan surat
        foreach ($surat->ruangans as $ruangan) {
            $surat->ruangans()->updateExistingPivot($ruangan->id, ['status' => $status]);
        }

        if($status){
            if($surat->file_surat){
                Storage::delete($path);
            }
        }

        if($status == 'ditolak'){
            $surat->update(['status' => 'ditolak']);    
        }

        if ($status == 'diterima') {
            $surat->update(['status' => 'diterima']);
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
