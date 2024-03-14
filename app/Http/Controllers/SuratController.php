<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\surat;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoresuratRequest;
use App\Http\Requests\UpdatesuratRequest;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.surat.index');
    }

    public function peminjaman()
    {

        $surat = surat::orderby('created_at', 'desc')->Paginate(10);

        // dd($surat);
        return view('admin.surat.peminjaman', ['suratList' => $surat]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create_peminjaman()
    {
        return view('admin.surat.peminjaman-tambah');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store_peminjaman(Request $request)
    {
        $namaBaru = '';

        if ($request->file('file')) {

            $request->validate([
                'file' => 'required|mimes:pdf|max:2048',
            ]);

            $now = now();
            $tanggalJam = $now->format('dmY-His');
            $exstension = $request->file('file')->getClientOriginalExtension();
            $namaBaru = $request->asal_surat . '-' . $request->nama_peminjam . ' ' . $tanggalJam . '.' . $exstension;
            $request->file('file')->storeAs('file_surat', $namaBaru, 'public');
        } else {
            // Jika file tidak diunggah, berikan pesan kesalahan dan kembalikan pengguna ke halaman sebelumnya
            return redirect()->back()->with('error', 'File harus diunggah.')->withInput($request->except('file'));
        }

        $request['status'] = 'pending';

        $request['file_surat'] = $namaBaru;

        $surat = surat::create($request->all());

        return redirect('/admin/peminjaman')->with('success', 'Surat Berhasil Ditambahkan');
    }

    public function respond()
    {
        //
    }

    public function bikinPDF(Request $request, $suratId)
    {

        // Mengambil data surat berdasarkan $suratId beserta relasinya
        $surat = Surat::with(['ruangans' => function ($query) {
            $query->withPivot('mulai_dipinjam', 'selesai_dipinjam'); // Mengambil kolom-kolom tambahan dari pivot table
        }])->findOrFail($suratId);

        // Menyiapkan data yang diperlukan untuk PDF
        $nomorSurat = $surat->nomor_surat;
        $asalSurat = $surat->asal_surat;
        $namaPeminjam = $surat->nama_peminjam;
        $jmlPc = $surat->jml_pc;
        $jmlRuang = $surat->jml_ruang;
        $status = $surat->status;
        $tanggal = now()->format('d F Y');
        $mulaiDipinjam = $surat->ruangans->first()->pivot->mulai_dipinjam;
        $selesaiDipinjam = $surat->ruangans->first()->pivot->selesai_dipinjam;
        $ruangans = $surat->ruangans;

        // Membuat objek Dompdf
        $dompdf = new Dompdf();

        // Mengatur ukuran dan orientasi halaman
        $dompdf->setPaper('A4', 'portrait');

        // Memuat view PDF Blade dengan data yang telah disiapkan
        $pdfContent = view('pdf.surat_balasan', compact('status','tanggal','jmlRuang','jmlPc','nomorSurat', 'asalSurat', 'namaPeminjam', 'mulaiDipinjam', 'selesaiDipinjam', 'ruangans'))->render();

        // Memuat konten HTML ke Dompdf
        $dompdf->loadHtml($pdfContent);

        // Render PDF
        $dompdf->render();

        $filename = 'surat_balasan_Untuk_' . str_replace(' ', '_', $asalSurat) . '.pdf';

        return $dompdf->stream($filename);
    }

    /**
     * Display the specified resource.
     */
    public function show(surat $surat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(surat $surat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatesuratRequest $request, surat $surat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $surat = surat::FindOrFail($id);
        $surat->delete();
        session()->flash('success', 'Data berhasil dihapus');
        return redirect('/admin/peminjaman')->with('success', 'Data berhasil dihapus');
    }
}
