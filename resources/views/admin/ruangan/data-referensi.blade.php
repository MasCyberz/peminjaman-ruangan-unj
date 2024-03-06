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

        @if (session()->has('success'))
            <div id="alert-border-3"
                class="fixed top-2 right-0 z-50 m-14 w-1/3 flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800"
                role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <div class="ms-3 text-lg font-medium">
                    {{ session()->get('success') }}
                </div>
                <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-border-3" aria-label="Close">
                    <span class="sr-only">Dismiss</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif

        <a href="{{ route('tambah_ruangan') }}"
            class="relative text-xl left-[11.5rem] mt-2 inline-flex items-center bg-gray-500 hover:bg-slate-600 text-white py-2 px-2 rounded-lg transition-all duration-300 ease-in-out font-semibold focus:outline-none focus: focus:ring-4 focus:ring-slate-600">
            <i class='bx bx-plus text-3xl'></i>
            Tambah Data
        </a>

        @foreach ($ruanganList as $index => $ruang)
            <div class="my-5 mx-auto rounded-lg shadow-all-side h-[420px] w-[70%] flex flex-col p-3 relative">

                <div class="flex my-auto relative mx-20">
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

                        <div class="flex gap-2 left-[25rem] top-[3rem] relative ">
                            <button
                                class="text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg inline-flex items-center justify-center w-full sm:w-auto px-2 py-2 text-center text-md shadow-[0_3px_4px_1px_rgba(0,0,0,0.3)]"><i
                                    class='bx bx-edit me-2'></i>Edit
                            </button>
                            <a
                                class="text-white bg-red-500 hover:bg-red-600  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg inline-flex items-center justify-center sm:w-auto px-2 py-2 text-center text-md">
                                <i class='bx bxs-trash me-2'></i>Hapus
                            </a>
                        </div>
                    </div>
                    {{-- <div class="right-0 mx-5 -z-0 flex-col w-[20rem]  absolute">
                        <img class="rounded-[50px]" src="{{ asset('storage/foto_ruangan/' . $ruang->gambar_ruang) }}"
                            alt="">
                    </div> --}}

                    <div class="bg-slate-300 h-[76%] w-1/2 rounded-3xl mx-auto bg-cover bg-center" style="background-image: url({{ asset('storage/foto_ruangan/' . $ruang->gambar_ruang) }})">

                    </div>

                    {{-- <img src="{{ asset('storage/foto_ruangan/' . $ruang->gambar_ruang) }}" class="bg-slate-300 h-[50%] w-1/2 rounded-3xl mx-auto bg-cover" alt="Deskripsi Gambar"> --}}
                </div>
            </div>
        @endforeach
        <br>
    </div>


@endsection
