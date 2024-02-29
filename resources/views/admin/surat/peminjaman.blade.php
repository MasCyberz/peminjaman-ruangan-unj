@extends('layouts.mainlayout-admin')

@section('title', 'Peminjaman')
@section('page', 'Peminjaman')

@section('content')
    <!-- ContentReal Start -->
    @if (session('success'))
        <div class="w-[90%] text-center mx-auto mt-5 p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
            role="alert">
            <span class="font-medium text-xl">Sukses ditambahkan</span>
        </div>
    @endif



    <div class="w-[90%] flex mx-auto py-2 ps-10 pe-4">
        <!-- <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 my-auto">
                                                                                                                                <i class='bx bx-plus text-2xl'></i>
                                                                                                                                Tambah Data
                                                                                                                            </button> -->
        <a href="{{ route('surat_tambah') }}">
            <button data-modal-target="default-modal" data-modal-toggle="default-modal" type="button"
                class="px-5 py-2.5 text-base font-medium text-center inline-flex items-center text-white bg-blue-500 rounded-full hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                <i class='bx bx-plus text-xl me-1'></i>
                Tambah Data
            </button>
        </a>



        <form class="max-w-md ms-auto my-auto">
            <label for="default-search" class="text-sm font-medium text-gray-900 sr-only">Search</label>
            <div class="relative">
                <input type="search" id="default-search"
                    class="block w-full p-1.5 ps-2 text-base font-medium text-gray-900 border border-gray-300 rounded-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500 focus:outline-none"
                    placeholder="Search" />
                <button type="submit"
                    class="text-white flex items-center absolute end-0 bottom-0 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-e-full text-sm px-4 py-2 hover:bg-gray-300">
                    <svg class="w-5 h-5 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1                 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <div class="flex flex-col mx-[6.25rem]">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full text-left rtl:text-right divide-y divide-gray-200 border border-black">
                        <thead>
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 whitespace-nowrap border border-black text-center text-xs font-medium uppercase">
                                    No</th>
                                <th scope="col"
                                    class="px-6 py-3 whitespace-nowrap border border-black text-center text-xs font-medium uppercase">
                                    Nomor Surat</th>
                                <th scope="col"
                                    class="px-6 py-3 whitespace-nowrap border border-black text-center text-xs font-medium uppercase">
                                    Asal Surat</th>
                                <th scope="col"
                                    class="px-6 py-3 whitespace-nowrap border border-black text-center text-xs font-medium uppercase">
                                    Nama Peminjam</th>
                                <th scope="col"
                                    class="px-6 py-3 whitespace-nowrap border border-black text-center text-xs font-medium uppercase">
                                    Tanggal Peminjam</th>
                                <th scope="col"
                                    class="px-6 py-3 whitespace-nowrap border border-black text-center text-xs font-medium uppercase">
                                    Lama Peminjam</th>
                                <th scope="col"
                                    class="px-6 py-3 whitespace-nowrap border border-black text-center text-xs font-medium uppercase">
                                    Jumlah Ruang</th>
                                <th scope="col"
                                    class="px-6 py-3 whitespace-nowrap border border-black text-center text-xs font-medium uppercase">
                                    Jumlah PC</th>
                                <th scope="col"
                                    class="px-6 py-3 whitespace-nowrap border border-black text-center text-xs font-medium uppercase">
                                    Status</th>
                                <th scope="col"
                                    class="px-6 py-3 whitespace-nowrap border border-black text-center text-xs font-medium uppercase">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-left">
                            @foreach ($suratList as $surat)
                                <tr>
                                    <th class="px-6 py-2 whitespace-nowrap border-x border-black text-sm">
                                        {{ $loop->iteration }}</th>
                                    <td class="px-6 py-2 whitespace-nowrap border-x border-black text-sm">
                                        {{ $surat->nomor_surat }}</td>
                                    <td class="px-6 py-2 whitespace-nowrap border-x border-black text-sm">
                                        {{ $surat->asal_surat }}</td>
                                    <td class="px-6 py-2 whitespace-nowrap border-x border-black text-sm">
                                        {{ $surat->nama_peminjam }}</td>
                                    <td class="px-6 py-2 whitespace-nowrap border-x border-black text-sm">
                                        @php
                                            try {
                                                $tanggal = \Carbon\Carbon::parse($surat->mulai_dipinjam);
                                                echo $tanggal->format('d-F-Y', 'Asia/Jakarta');
                                            } catch (\Exception $e) {
                                                echo 'Invalid Date';
                                            }
                                        @endphp
                                    </td>
                                    <td class="px-6 py-2 whitespace-nowrap border-x border-black text-sm">
                                        @php
                                            try {
                                                $tanggal = \Carbon\Carbon::parse($surat->selesai_dipinjam);
                                                echo $tanggal->format('d-F-Y', 'Asia/Jakarta');
                                            } catch (\Exception $e) {
                                                echo 'Invalid Date';
                                            }
                                        @endphp
                                    </td>
                                    <td class="px-6 py-2 whitespace-nowrap border-x border-black text-sm">
                                        {{ $surat->jml_ruang }}</td>
                                    <td class="px-6 py-2 whitespace-nowrap border-x border-black text-sm">
                                        {{ $surat->jml_pc }}
                                    </td>
                                    <td class="px-6 py-2 whitespace-nowrap border-x border-black text-sm">
                                        <div
                                            class="w-full h-full px-3 py-2 rounded-full uppercase text-center
                                        @if ($surat->status == 'diterima') bg-green-100 text-green-800
                                        @elseif ($surat->status == 'ditolak')
                                        bg-red-100 text-red-800
                                        @else
                                        bg-gray-100 text-gray-500 @endif">
                                            <span class="font-medium">{{ $surat->status }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-2 whitespace-nowrap border-x border-black text-sm">
                                        <button type="button"
                                            class="text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-3 py-2 text-center">Print
                                            Out</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- ContentReal End -->
    </div>
@endsection
