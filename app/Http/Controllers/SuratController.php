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
use App\Models\User;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $peminjaman = surat::select('status')->where('status', 'pending')->count();
        $akun = User::count();
        return view('admin.surat.index', ['peminjaman' => $peminjaman, 'akun' => $akun]);
    }

    public function peminjaman(Request $request)
    {
    //   // Ambil kata kunci pencarian dari form
    // $search = $request->input('search');

    // // Jika ada pencarian, simpan kata kunci pencarian ke dalam sesi
    // if ($search !== null) {
    //     $request->session()->put('search', $search);
    // }

    // // Ambil kata kunci pencarian dari sesi
    // $search = $request->session()->get('search');

    // // Bangun kueri pencarian untuk mencari surat berdasarkan kata kunci
    // $surat = Surat::where(function ($query) use ($search) {
    //     $query->where('nomor_surat', 'like', '%' . $search . '%')
    //         ->orWhere('asal_surat', 'like', '%' . $search . '%')
    //         ->orWhere('nama_peminjam', 'like', '%' . $search . '%');
    // })->orderBy('created_at', 'desc')->paginate(2);


    // Ambil kata kunci pencarian dari form
    $search = $request->input('search');

    // Simpan kata kunci pencarian ke dalam sesi
    $request->session()->put('search', $search);

    // Ambil kata kunci pencarian dari sesi
    $search = $request->session()->get('search');

    // Bangun kueri pencarian untuk mencari surat berdasarkan kata kunci
    $surat = Surat::where(function ($query) use ($search) {
        $query->where('nomor_surat', 'like', '%' . $search . '%')
            ->orWhere('asal_surat', 'like', '%' . $search . '%')
            ->orWhere('nama_peminjam', 'like', '%' . $search . '%');
    })->orderBy('created_at', 'desc')->paginate(2);

    // Setelah mengambil hasil pencarian, hapus kata kunci pencarian dari sesi
    $request->session()->forget('search');

    // Tampilkan hasil pencarian ke tampilan
    return view('admin.surat.peminjaman', ['suratList' => $surat]);

    
    // Tampilkan hasil pencarian ke tampilan
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

        $request->validate(
            [
                'file' => 'required|mimes:pdf|max:2048',
                'nomor_surat' => 'required',
                'asal_surat' => 'required',
                'nama_peminjam' => 'required',
                'mulai_dipinjam' => 'required',
                'selesai_dipinjam' => 'required',
                'jml_ruang' => 'required|numeric',
                'jml_pc' => 'required|numeric',

            ],
            [
                'required' => ' :attribute harus diisi',
                'file.mimes' => 'File harus berupa PDF',
                'jml_pc.required' =>'Jumlah PC harus diisi',
                'jml_ruang.required' =>'Jumlah Ruang harus diisi',
            ]
        );

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            if ($file->isValid()) {
                $extension = $file->getClientOriginalExtension();
                $namaBaru = $request->asal_surat . '-' . $request->nama_peminjam . '-' . uniqid() . '.' . $extension;
                $file->storeAs('file_surat', $namaBaru, 'public');
            } else {
                return redirect()->back()->with('error', 'File tidak valid.')->withErrors(['file' => 'File tidak valid']);
            }
        } else {
            return redirect()->back()->with('error', 'File harus diunggah.')->withErrors(['file' => 'File harus diunggah']);
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
            $query->withPivot('mulai_dipinjam', 'selesai_dipinjam', 'status'); // Mengambil kolom-kolom tambahan dari pivot table
        }])->findOrFail($suratId);


        $statusDiterima = $surat->ruangans->contains(function ($ruangan) {
            return $ruangan->pivot->status === 'diterima';
        });

        // Menyiapkan data yang diperlukan untuk PDF
        $nomorSurat = $surat->nomor_surat;
        $asalSurat = $surat->asal_surat;
        $namaPeminjam = $surat->nama_peminjam;
        $jmlPc = $surat->jml_pc;
        $jmlRuang = $surat->jml_ruang;
        $statusSurat = $surat->status;
        $alasanSurat = $surat->alasan_penolakan;
        $tanggal = now()->format('d F Y');
        $mulaiDipinjam = $surat->mulai_dipinjam;
        $selesaiDipinjam = $surat->selesai_dipinjam;
        $ruangans = $surat->ruangans;

        // Membuat objek Dompdf
        $dompdf = new Dompdf();

        // Mengatur ukuran dan orientasi halaman
        $dompdf->setPaper('A4', 'portrait');

        // Memuat view PDF Blade dengan data yang telah disiapkan
        $pdfContent = view('pdf.surat_balasan', compact('alasanSurat','statusDiterima', 'statusSurat', 'tanggal', 'jmlRuang', 'jmlPc', 'nomorSurat', 'asalSurat', 'namaPeminjam', 'mulaiDipinjam', 'selesaiDipinjam', 'ruangans'))->render();

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
