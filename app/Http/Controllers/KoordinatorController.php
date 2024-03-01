<?php

namespace App\Http\Controllers;

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
        return view('koordinator.surat.data_referensi-koordinator');
    }


}
