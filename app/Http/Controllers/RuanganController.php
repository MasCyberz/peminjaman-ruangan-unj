<?php

namespace App\Http\Controllers;

use App\Models\ruangan;
use App\Models\fasilitas;
use Illuminate\Http\Request;
use App\Http\Requests\StoreruanganRequest;
use App\Http\Requests\UpdateruanganRequest;
use PhpParser\Node\Stmt\Foreach_;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ruangan = ruangan::with('fasilitas')->get();
        $fasilitas = fasilitas::get();
        return view('admin.ruangan.data-referensi', ['ruanganList' => $ruangan, 'fasilitasList' => $fasilitas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.ruangan.tambah-data-referensi');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try {

            $ruangan = ruangan::create([
                'nomor_ruang' => $request->input('nomor_ruang'),
                'nama_ruang' => $request->input('nama_ruang'),
                'jml_pc' => $request->input('jml_pc'),
                'kapasitas_orang' => $request->input('kapasitas_orang'),
            ]);

            if ($request->hasFile('foto')) {
                $now = now();
                $tanggalJam = $now->format('dmY-His');
                $extension = $request->file('foto')->getClientOriginalExtension();
                $namaBaru = $request->nomor_ruang . '-' . $tanggalJam . '.' . $extension;
                $request->file('foto')->storeAs('foto_ruangan', $namaBaru, 'public');
                $ruangan->gambar_ruang = $namaBaru;
                $ruangan->save();
            }

            $fasilitas = $request->input('fasilitas');
            foreach ($fasilitas['nama_fasilitas'] as $key => $namaFasilitas) {
                fasilitas::create([
                    'nama_fasilitas' => $namaFasilitas,
                    'jumlah' => $fasilitas['jumlah'][$key],
                    'ruangans_id' => $ruangan->id,
                ]);
            }

            return redirect('/admin/data-referensi')->with('success', 'Data ruangan baru ditambahkan');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan data. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ruangan $ruangan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ruangan $ruangan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateruanganRequest $request, ruangan $ruangan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ruangan $ruangan)
    {
        //
    }
}
