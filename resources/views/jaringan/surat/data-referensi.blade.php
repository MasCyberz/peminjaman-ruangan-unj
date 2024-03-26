@extends('layouts.mainlayout-jaringan')

@section('title', 'Jaringan-Data Referensi')
@section('page', 'Data Referensi')

@section('content')

    @foreach ($ruanganList as $index => $ruang)
        <div class="my-5 mx-auto rounded-lg shadow-all-side h-auto w-[80%] flex flex-col p-3 relative">

            <div class="flex my-auto relative mx-5">
                <div class="flex flex-col z-10 whitespace-nowrap">
                    <span class="block mt-3 mx-3 text-base font-semibold">Nomor Ruangan</span>
                    <span class="block mt-3 mx-3 text-base font-semibold">Nama Ruangan</span>
                    <span class="block mt-3 mx-3 text-base font-semibold">Jumlah PC</span>
                    <span class="block mt-3 mx-3 text-base font-semibold">Kapasitas Orang</span>
                    <span class="block mt-3 mx-3 text-base font-semibold">Fasilitas</span>
                </div>
                <div class="flex flex-col z-10 whitespace-nowrap">
                    <span class="mt-3 text-base font-semibold mx-3">:</span>
                    <span class="mt-3 text-base font-semibold mx-3">:</span>
                    <span class="mt-3 text-base font-semibold mx-3">:</span>
                    <span class="mt-3 text-base font-semibold mx-3">:</span>
                    <span class="mt-3 text-base font-semibold mx-3">:</span>
                </div>
                <div class="flex flex-col z-10 relative whitespace-nowrap">
                    <span class="mt-3 text-base font-semibold mx-3">{{ $ruang->nomor_ruang }}</span>
                    <span class="mt-3 text-base font-semibold mx-3">{{ $ruang->nama_ruang }}</span>
                    <span class="mt-3 text-base font-semibold mx-3">{{ $ruang->jml_pc }}</span>
                    <span class="mt-3 text-base font-semibold mx-3">{{ $ruang->kapasitas_orang }}</span>
                    <span class="mt-3 text-base font-semibold mx-3">
                        <ul>
                            @foreach ($ruang->fasilitas as $fasilitas)
                                @if ($ruang->fasilitas && $fasilitas->nama_fasilitas && $fasilitas->jumlah)
                                    <li> <span>{{ $fasilitas->jumlah }}</span>
                                        <span>{{ $fasilitas->nama_fasilitas }}</span>
                                    </li>
                                @else
                                @endif
                            @endforeach
                        </ul>
                    </span>

                </div>
                {{-- <div class="right-0 mx-5 -z-0 flex-col w-[20rem]  absolute">
                        <img class="rounded-[50px]" src="{{ asset('storage/foto_ruangan/' . $ruang->gambar_ruang) }}"
                        alt="">
                    </div> --}}

                <div class="bg-slate-300 mb-5 relative -right-20 top-2 h-[15rem] w-[45%] rounded-3xl mx-auto bg-cover bg-center"
                    style="background-image: url({{ asset('storage/foto_ruangan/' . $ruang->gambar_ruang) }})">

                </div>

                {{-- <img src="{{ asset('storage/foto_ruangan/' . $ruang->gambar_ruang) }}" class="bg-slate-300 h-[50%] w-1/2 rounded-3xl mx-auto bg-cover" alt="Deskripsi Gambar"> --}}
            </div>
        </div>
    @endforeach
    <br>
    </div>

@endsection
