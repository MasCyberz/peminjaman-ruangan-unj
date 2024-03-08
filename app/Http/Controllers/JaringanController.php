<?php

namespace App\Http\Controllers;

use App\Models\surat;
use App\Models\ruangan;
use Illuminate\Http\Request;
use App\Models\fasilitas;
use App\Models\RuangPeminjaman;

class JaringanController extends Controller
{
    public function index()
    {
        return view('jaringan.surat.index');
    }

    public function table_peminjaman(Request $request)
    {
        $ruangan = ruangan::get();

        $limit = $request->input('numero', 10);
        $surat = surat::where('nomor_surat', 'like', '%' . $request->keyword . '%')
            ->orWhere('asal_surat', 'like', '%' . $request->keyword . '%')
            ->orderby('created_at', 'desc')
            ->paginate($limit);
        return view('jaringan.surat.peminjaman-jaringan', ['suratList' => $surat, 'numero' => $request->input('numero'), 'ruanganList' => $ruangan]);
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
        $validatedData = $request->validate([
            'nomor_surat' => 'required',
            'asal_surat' => 'required',
            'ruangan' => 'required|array',
            'ruangan.*' => 'required|distinct|exists:ruangans,id',
        ]);


        $surat = Surat::findOrFail($suratId);

        // Logika untuk mengecek jadwal ruangan
        foreach ($validatedData['ruangan'] as $ruanganId) {
            $konflik = Ruangan::whereHas('surats', function ($query) use ($surat, $ruanganId) {
                $query->where('ruangans_id', $ruanganId)
                    ->where(function ($query) use ($surat) {
                        $query->whereBetween('ruang_peminjaman.mulai_dipinjam', [$surat->mulai_dipinjam, $surat->selesai_dipinjam])
                            ->orWhereBetween('ruang_peminjaman.selesai_dipinjam', [$surat->mulai_dipinjam, $surat->selesai_dipinjam]);
                    });
            })->exists();

            if ($konflik) {
                return back()->withErrors(['ruangan' => 'Ruangan dengan ID ' . $ruanganId . ' tidak tersedia pada jadwal yang dipilih.']);
            }
        }


        foreach ($validatedData['ruangan'] as $ruanganId) {
            $surat->ruangans()->attach($ruanganId, [
                'mulai_dipinjam' => $surat->mulai_dipinjam,
                'selesai_dipinjam' => $surat->selesai_dipinjam
            ]);
        }

        return redirect()->route('peminjaman_jaringan')->with('success', 'Peminjaman ruangan berhasil disimpan.');
    }
}
