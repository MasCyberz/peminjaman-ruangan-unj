<?php

namespace App\Http\Controllers;

use App\Models\surat;
use App\Models\ruangan;
use Illuminate\Http\Request;
use App\Models\fasilitas;

class JaringanController extends Controller
{
    public function index(){
        return view('jaringan.surat.index');
    }

    public function table_peminjaman(Request $request){
        $limit = $request->input('numero', 10);
        $surat = surat::where('nomor_surat', 'like', '%' . $request->keyword . '%')
                        ->orWhere('asal_surat', 'like', '%' . $request->keyword . '%')
                        ->paginate($limit);
        return view('jaringan.surat.peminjaman-jaringan', ['suratList' => $surat, 'numero' => $request->input('numero')]);
    }

    public function data_referensi(){
        $ruangan = ruangan::with('fasilitas')->get();
        $fasilitas = fasilitas::get();
        return view('jaringan.surat.data-referensi', ['ruanganList' => $ruangan, 'fasilitasList' => $fasilitas]);
    }

    public function show_detail($id){
        $surat = surat::FindOrFail($id);
        return view('jaringan.surat.detail-surat-peminjaman', ['suratList' => $surat]);
    }
    



}