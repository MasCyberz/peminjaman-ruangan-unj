<?php

namespace App\Http\Controllers;

use App\Models\surat;
use App\Http\Requests\StoresuratRequest;
use App\Http\Requests\UpdatesuratRequest;
use Illuminate\Http\Request;

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

        $surat = surat::get();

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
