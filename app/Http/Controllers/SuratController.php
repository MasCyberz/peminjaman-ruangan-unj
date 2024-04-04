<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\User;
use App\Models\surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $peminjaman = surat::where(function ($query) {
            $query->where('status', 'pending')
            ->orWhere('status', 'ditolak');
        })
        ->whereDoesntHave('ruangans', function ($query) {
            $query->where('ruang_peminjaman.status', 'diterima')
                ->orWhere('ruang_peminjaman.status', 'ditolak');
        })
        ->count();
        $akun = User::count();
        return view('admin.surat.index', ['peminjaman' => $peminjaman, 'akun' => $akun]);
    }

    public function peminjaman(Request $request)
    {
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
        })->orderBy('created_at', 'desc')->paginate(10);

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
                'jml_pc.required' => 'Jumlah PC harus diisi',
                'jml_ruang.required' => 'Jumlah Ruang harus diisi',
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
        $pdfContent = view('pdf.surat_balasan', compact('surat','alasanSurat', 'statusDiterima', 'statusSurat', 'tanggal', 'jmlRuang', 'jmlPc', 'nomorSurat', 'asalSurat', 'namaPeminjam', 'mulaiDipinjam', 'selesaiDipinjam', 'ruangans'))->render();

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
    public function edit(request $request, $id)
    {
        $surat = surat::findOrFail($id);
        return view('admin.surat.edit_surat', ['SuratYgDiedit' => $surat]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        try {

            $surat = surat::findOrFail($id);

            $request->validate([
                'file' => 'mimes:pdf|max:2048',
                'nomor_surat' => 'required',
                'asal_surat' => 'required',
                'nama_peminjam' => 'required',
                'mulai_dipinjam' => 'required',
                'selesai_dipinjam' => 'required',
                'jml_ruang' => 'required|numeric',
                'jml_pc' => 'required|numeric',
            ], [
                'required' => ' :attribute harus diisi',
                'file.mimes' => 'File harus berupa PDF',
                'jml_pc.required' => 'Jumlah PC harus diisi',
                'jml_ruang.required' => 'Jumlah Ruang harus diisi',
            ]);

            if ($request->hasFile('file')) {
                $file = $request->file('file');

                if ($file->isValid()) {
                    if ($surat->file_surat) {
                        Storage::delete('public/file_surat/' . $surat->file_surat);
                    }

                    $extension = $file->getClientOriginalExtension();
                    $namaBaru = $request->asal_surat . '-' . $request->nama_peminjam . '-' . uniqid() . '.' . $extension;
                    $file->storeAs('file_surat', $namaBaru, 'public');

                    $surat->file_surat = $namaBaru;
                } else {
                    return redirect()->back()->with('error', 'File tidak valid.')->withErrors(['file' => 'File tidak valid']);
                }
            } else {

            }

            $surat->nomor_surat = $request->input('nomor_surat');
            $surat->asal_surat = $request->input('asal_surat');
            $surat->nama_peminjam = $request->input('nama_peminjam');
            $surat->mulai_dipinjam = $request->input('mulai_dipinjam');
            $surat->selesai_dipinjam = $request->input('selesai_dipinjam');
            $surat->jml_ruang = $request->input('jml_ruang');
            $surat->jml_pc = $request->input('jml_pc');

            $surat->save();

            return redirect()->route('peminjaman')->with('success', 'Surat berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
