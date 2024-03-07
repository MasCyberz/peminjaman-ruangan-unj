<?php

namespace App\Http\Controllers;

use App\Models\ruangan;
use App\Models\fasilitas;
use Illuminate\Http\Request;

class KoordinatorController extends Controller
{

    public function index(){
        return view('koordinator.surat.index');
    }

    public function pengajuan(){
        return view('koordinator.surat.pengajuan-koordinator');
    }

    public function data_referensi(){
        $ruangan = ruangan::with('fasilitas')->get();
        $fasilitas = fasilitas::get();
        return view('koordinator.surat.data_referensi-koordinator', ['ruanganList' => $ruangan, 'fasilitasList' => $fasilitas]);
    }


}
