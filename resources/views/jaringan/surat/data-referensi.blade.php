@extends('layouts.mainlayout-jaringan')

@section('title', 'Jaringan-Data Referensi')
@section('page', 'Data Referensi')

@section('content')

<div class="w-[calc(100%-8rem)] h-full mx-auto py-3 px-4">
    @foreach ($ruanganList as $index => $ruang)
            <div class="my-7 mx-auto rounded-lg shadow-all-side h-[420px] w-[80%] flex flex-col p-3 relative">

                <div class="flex my-auto justify-center relative">
                    <div class="flex flex-col z-10">
                        <span class="block mt-3 mx-3 text-base font-semibold">Nomor Ruangan</span>
                        <span class="block mt-3 mx-3 text-base font-semibold">Nama Ruangan</span>
                        <span class="block mt-3 mx-3 text-base font-semibold">Jumlah PC</span>
                        <span class="block mt-3 mx-3 text-base font-semibold">Kapasitas Orang</span>
                        <span class="block mt-3 mx-3 text-base font-semibold">Fasilitas</span>
                    </div>
                    <div class="flex flex-col z-10">
                        <span class="mt-3 text-base font-semibold mx-3">:</span>
                        <span class="mt-3 text-base font-semibold mx-3">:</span>
                        <span class="mt-3 text-base font-semibold mx-3">:</span>
                        <span class="mt-3 text-base font-semibold mx-3">:</span>
                        <span class="mt-3 text-base font-semibold mx-3">:</span>
                    </div>
                    <div class="flex flex-col z-10 relative">
                        <span class="mt-3 text-base font-semibold mx-3">{{ $ruang->nomor_ruang }}</span>
                        <span class="mt-3 text-base font-semibold mx-3">{{ $ruang->nama_ruang }}</span>
                        <span class="mt-3 text-base font-semibold mx-3">{{ $ruang->jml_pc }}</span>
                        <span class="mt-3 text-base font-semibold mx-3">{{ $ruang->kapasitas_orang }}</span>
                        <span class="mt-3 text-base font-semibold mx-3">
                            <ul>
                                @foreach ($ruang->fasilitas as $fasilitas)
                                    @if ($ruang->fasilitas && $fasilitas->nama_fasilitas && $fasilitas->jumlah)
                                        <li> <span>{{ $fasilitas->jumlah }}</span>
                                            <span>{{ $fasilitas->nama_fasilitas }}</span> </li>
                                    @else
                                        -
                                    @endif
                                @endforeach
                            </ul>
                        </span>
                        <div class="flex right-0 -z-0 flex-col w-[17.5rem] absolute">
                            <img class="rounded-[50px]" src="./img/taro-ohtani-1kU3F0v90NY-unsplash.jpg" alt="">
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection