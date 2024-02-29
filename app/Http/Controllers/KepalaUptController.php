<?php

namespace App\Http\Controllers;

use App\Models\surat;
use Illuminate\Http\Request;

class KepalaUptController extends Controller
{
    public function index()
    {
        return view('kepala-upt.surat.index');
    }

    public function peminjaman()
    {
        $surat = surat::get();

        // dd($surat);
        return view('kepala-upt.surat.surat-pengajuan', ['suratList' => $surat]);
    }

    public function show_peminjaman($id)
    {
        $pengajuan = surat::FindOrFail($id);

        return view('kepala-upt.surat.surat-pengajuan-detail', ['pengajuanList' => $pengajuan]);
    }

    public function respond(Request $request, $id)
    {
        $surat = surat::FindOrFail($id);

        if ($request->response == 'accept') {
            $surat->status = 'diterima';
            $message = 'Surat berhasil diterima.';
        } elseif ($request->response == 'reject') {
            $surat->status = 'ditolak';
            $message = 'Surat berhasil ditolak.';
        }

        $surat->save(); 
        return redirect('/kepala-upt/peminjaman')->with('success', $message);
    }
}
