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
        $validateData = $request->validate([
            'nomor_ruang' => 'required|integer',
            'nama_ruang' => 'required|string',
            'jml_pc' => 'required|integer',
            'kapasitas_orang' => 'required|integer',
            'foto' => 'image|mimes:jpeg,png,jpg|max:10240',
            'fasilitas.nama_fasilitas' => 'required|array',
            'fasilitas.nama_fasilitas.*' => 'required|string|max:255',
            'fasilitas.jumlah' => 'required|array',
            'fasilitas.jumlah.*' => 'required|integer',
        ],[
            'nomor_ruang.required' => 'Nomor ruang harus diisi',
            'nomor_ruang.integer' => 'Nomor ruang harus berupa angka',
            'nama_ruang.required' => 'Nama ruang harus diisi',
            'jml_pc.required' => 'Jumlah PC harus diisi',
            'jml_pc.integer' => 'Jumlah PC harus berupa angka',
            'kapasitas_orang.required' => 'Kapasitas orang harus diisi',
            'kapasitas_orang.integer' => 'Kapasitas ruang harus berupa angka',
            'fasilitas.required' => 'Fasilitas harus diisi',
            'fasilitas.jumlah.*.required' => 'Jumlah fasilitas harus diisi',

        ]);
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

            $fasilitas = $validateData['fasilitas'];
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
    public function edit($id)
    {
        $ruangan = ruangan::findOrFail($id);
        $fasilitas = fasilitas::where('ruangans_id', $id)->get();
        return view('admin.ruangan.edit-data-referensi', ['ruanganList' => $ruangan, 'fasilitasList' => $fasilitas]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(request $request, $id)
    {
        try{
        $ruangan = ruangan::findOrFail($id);

        $ruangan->nomor_ruang = $request->input('nomor_ruang');
        $ruangan->nama_ruang = $request->input('nama_ruang');
        $ruangan->jml_pc = $request->input('jml_pc');
        $ruangan->kapasitas_orang = $request->input('kapasitas_orang');
        $ruangan->save();

        $ruangan->fasilitas()->delete();

        $fasilitas = $request->input('fasilitas');
        foreach ($fasilitas['nama_fasilitas'] as $key => $namaFasilitas) {
            fasilitas::create([
                'nama_fasilitas' => $namaFasilitas,
                'jumlah' => $fasilitas['jumlah'][$key],
                'ruangans_id' => $ruangan->id,
            ]);
        }
        return redirect('/admin/data-referensi')->with('success', 'Data ruangan berhasil diperbarui');
    }catch (\Exception $e) {
        return back()->with('error', 'Gagal merubah data. Coba lagi.');
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ruangan $ruangan, $id)
    {
        $ruangan = ruangan::findOrFail($id);
        $ruangan->fasilitas()->delete();
        $ruangan->delete();
        return redirect('/admin/data-referensi')->with('success', 'Data ruangan berhasil dihapus');
    }
}
