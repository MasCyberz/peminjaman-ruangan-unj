<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JaringanController extends Controller
{
    public function index(){
        return view('jaringan.surat.index');
    }

    public function table_peminjaman(){
        return view('jaringan.surat.peminjaman-jaringan');
    }

    public function data_referensi(){
        return view('jaringan.surat.data-referensi');
    }

    

}