@extends('layouts.mainlayout-admin')
@section('title', 'Data Referensi')
@section('page', 'Data Referensi')

@section('content')

    <div class="w-[calc(100%-8rem)] h-full mx-auto py-3 px-4">

        {{-- <a href="{{ route('tambah_ruangan') }}"
            class="flex items-center transition-all duration-300 ease-in-out  hover:bg-sidebarunj hover:text-white h-11 w-full py-1">
            <i data-tooltip-target="tooltip-right" data-tooltip-placement="right"
                class='bx bx-plus text-4xl rounded-b-lg text-sidebarunj font-medium '></i>
            <span class="text-xl font-semibold text-sidebarunj">Tambah Data</span>
        </a> --}}

        <a href="{{ route('tambah_ruangan') }}"
            class="relative text-xl left-[7.7rem] mt-2 inline-flex items-center bg-gray-500 hover:bg-slate-600 text-white py-2 px-2 rounded-lg transition-all duration-300 ease-in-out font-semibold focus:outline-none focus: focus:ring-4 focus:ring-slate-600">
            <i class='bx bx-plus text-3xl'></i>
            Tambah Data
        </a>

        {{-- @php
            $tombolDitampilkan = false;
        @endphp --}}

        @foreach ($ruanganList as $index => $ruang)
            <div class="my-7 mx-auto rounded-lg shadow-all-side h-[420px] w-[80%] flex flex-col p-3 relative">
                {{-- @if (!$tombolDitampilkan && $index === 0)
                    @php
                        $tombolDitampilkan = true;
                    @endphp
                    <div class="absolute w-14 h-11 inline-flex items-center justify-center left-0 top-0 transition-all duration-300 ease-in-out">
                        <a href="{{ route('tambah_ruangan') }}"><i data-tooltip-target="tooltip-right"
                                data-tooltip-placement="right"
                                class='bx bx-plus text-4xl hover:bg-sidebarunj h-11 py-1 rounded-b-lg text-sidebarunj font-medium hover:text-white transition-all duration-300 ease-in-out'></i></a>
                    </div>
                @endif --}}



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
                                            <span>{{ $fasilitas->nama_fasilitas }}</span>
                                        </li>
                                    @else
                                        -
                                    @endif
                                @endforeach
                            </ul>
                        </span>
                        <div class="flex right-0 -z-0 flex-col w-[17.5rem] absolute">
                            <img class="rounded-[50px]" src="" alt="">
                        </div>

                        <div class="p-4 ms-auto">
                            <button
                                class="text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg inline-flex items-center justify-center w-full sm:w-auto px-2 py-2.5 text-center text-md"><i
                                    class='bx bx-edit me-2'></i>Edit
                            </button>
                            <button
                                class="text-white bg-red-500 hover:bg-red-600  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg inline-flex items-center justify-center sm:w-auto px-2 py-2.5 text-center text-md"><i
                                    class='bx bxs-trash me-2'></i>Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


@endsection
