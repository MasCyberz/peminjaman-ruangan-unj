<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\surat;
use App\Models\ruangan;
use App\Models\fasilitas;
use Illuminate\Http\Request;
use App\Models\RuangPeminjaman;
use Illuminate\Support\Facades\Storage;

class KoordinatorController extends Controller
{

    public function index()
    {
        $permintaanRuang = surat::with('ruangans')
            ->whereHas('ruangans', function ($query) {
                $query->where('ruang_peminjaman.status', 'pending');
            })->count();
        return view('koordinator.surat.index', ['permintaanRuang' => $permintaanRuang]);
    }

    public function pengajuan()
    {

        // $permintaanRuang = Surat::with(['ruangans'])->get();

        $suratIsPending = RuangPeminjaman::where('status', 'pending')->pluck('surat_id')->toArray();

        if (!empty($suratIsPending)) {
            // Jika ada surat pending, gunakan FIELD untuk mengurutkan
            $surat = Surat::with('detailPeminjaman')
                ->orderByRaw("FIELD(id, " . implode(',', $suratIsPending) . ") DESC, created_at DESC")
                ->paginate(15);
        } else {
            // Jika tidak ada surat pending, urutkan berdasarkan created_at atau kriteria lain
            $surat = Surat::with('detailPeminjaman')
                ->orderBy('created_at', 'DESC')
                ->paginate(15);
        }
        // Kelompokkan ruangan-ruangan berdasarkan tanggal peminjaman
        // $groupedRuangans = $permintaanRuang->flatMap(function ($surat) {
        //     return $surat->ruangans->mapToGroups(function ($ruangan) {
        //         return [$ruangan->pivot->tanggal_peminjaman => $ruangan];
        //     });
        // });

        $groupedRuangans = $surat->flatMap(function ($surat) {
            return $surat->ruangans->mapToGroups(function ($ruangan) {
                return [$ruangan->pivot->tanggal_peminjaman => $ruangan];
            });
        });


        // dd($permintaanRuang);

        return view('koordinator.surat.pengajuan-koordinator', ['permintaanRuang' => $surat, 'groupedRuangans' => $groupedRuangans]);
    }

    public function getRuangPeminjamanDetail($suratId){
        // Mengambil data ruang_peminjaman berdasarkan surat_id
        $ruangPeminjaman = RuangPeminjaman::where('surat_id', $suratId)->get();

        // Mengelompokkan data ruang_peminjaman berdasarkan tanggal_peminjaman
        $groupedRuangPeminjaman = $ruangPeminjaman->groupBy('tanggal_peminjaman');

        // Format data untuk ditampilkan pada view
        $formattedData = [];
        foreach ($groupedRuangPeminjaman as $tanggalPeminjaman => $ruangPeminjamans) {
            $formattedRuangPeminjaman = [];
            foreach ($ruangPeminjamans as $ruangPeminjaman) {
                $formattedRuangPeminjaman[] = [
                    'nomor_ruang' => $ruangPeminjaman->ruangan->nomor_ruang,
                    'tanggal_peminjaman' => Carbon::parse($ruangPeminjaman->tanggal_peminjaman)->format('d F Y'),
                ];
            }
            $formattedData[] = [
                'tanggal_peminjaman' => $tanggalPeminjaman,
                'ruang_peminjaman' => $formattedRuangPeminjaman,
            ];
        }
    }

    public function getRuangPeminjamanDetail($suratId){
        // Mengambil data ruang_peminjaman berdasarkan surat_id
        $ruangPeminjaman = RuangPeminjaman::where('surat_id', $suratId)->get();

        // Mengelompokkan data ruang_peminjaman berdasarkan tanggal_peminjaman
        $groupedRuangPeminjaman = $ruangPeminjaman->groupBy('tanggal_peminjaman');

        // Format data untuk ditampilkan pada view
        $formattedData = [];
        foreach ($groupedRuangPeminjaman as $tanggalPeminjaman => $ruangPeminjamans) {
            $formattedRuangPeminjaman = [];
            foreach ($ruangPeminjamans as $ruangPeminjaman) {
                $formattedRuangPeminjaman[] = [
                    'nomor_ruang' => $ruangPeminjaman->ruangan->nomor_ruang,
                    'tanggal_peminjaman' => Carbon::parse($ruangPeminjaman->tanggal_peminjaman)->format('d F Y'),
                ];
            }
            $formattedData[] = [
                'tanggal_peminjaman' => $tanggalPeminjaman,
                'ruang_peminjaman' => $formattedRuangPeminjaman,
            ];
        }
    }

    public function pengajuan_store(Request $request, $suratId)
    {

        $status = $request->status; // 'approved' atau 'rejected'

        $surat = Surat::findOrFail($suratId);

        $fileToDelete = $surat->file_surat; // Ganti dengan nama file yang ingin dihapus
        $path = 'public/file_surat/' . $fileToDelete;

        // Update status semua ruangan yang terkait dengan surat
        foreach ($surat->ruangans as $ruangan) {
            $surat->ruangans()->updateExistingPivot($ruangan->id, ['status' => $status]);
        }

        if ($status) {
            if ($surat->file_surat) {
                Storage::delete($path);
            }
        }

        if ($status == 'ditolak') {
            $surat->update(['status' => 'ditolak']);
        }

        if ($status == 'diterima') {
            $surat->update(['status' => 'diterima']);
        }


        return back()->with('success', 'Permintaan Berhasil ' . ($status == 'diterima' ? 'diterima' : 'ditolak') . '.');
    }

    public function data_referensi()
    {
        $ruangan = ruangan::with('fasilitas')->get();
        $fasilitas = fasilitas::get();
        return view('koordinator.surat.data_referensi-koordinator', ['ruanganList' => $ruangan, 'fasilitasList' => $fasilitas]);
    }
}
