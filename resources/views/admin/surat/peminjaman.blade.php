@extends('layouts.mainlayout-admin')

@section('title', 'Peminjaman')
@section('page', 'Peminjaman')

@section('content')
    <!-- ContentReal Start -->
    <div class="w-[90%] flex mx-auto py-2 ps-10 pe-4">
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

        <a href="{{ route('surat_tambah') }}">
            <button data-modal-target="default-modal" data-modal-toggle="default-modal" type="button"
                class="px-5 py-2.5 text-base font-medium text-center inline-flex items-center text-white bg-blue-500 rounded-full hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                <i class='bx bx-plus text-xl me-1'></i>
                Tambah Data
            </button>
        </a>



        <form class="max-w-md ms-auto my-auto" action="" method="GET">
            <label for="default-search" class="text-sm font-medium text-gray-900 sr-only">Search</label>
            <div class="relative">
                <input type="search" id="default-search" name="search"
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
                                        {{ $loop->iteration + $suratList->firstItem() - 1 }}</th>
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
                                        @php
                                            $statusDiterima = $surat->ruangans->contains(function ($ruangan) {
                                                return $ruangan->pivot->status === 'diterima';
                                            });

                                            $statusDitolak = $surat->ruangans->contains(function ($ruangan) {
                                                return $ruangan->pivot->status === 'ditolak';
                                            })
                                        @endphp
                                        <div
                                            class="w-full h-full px-3 py-2 rounded-full uppercase text-center
                                        @if ($statusDiterima && $surat->status == 'diterima') bg-green-100 text-green-800
                                        @elseif ($surat->status == 'ditolak' || $statusDitolak)
                                        bg-red-100 text-red-800
                                        @else
                                        bg-gray-100 text-gray-500 @endif">
                                            <span class="font-medium">
                                                @if ($surat->status == 'diterima' && $statusDiterima)
                                                    Diterima
                                                @elseif ($surat->status == 'ditolak' || $statusDitolak)
                                                    Ditolak
                                                @elseif ($surat->status == 'pending')
                                                    {{ $surat->status }}
                                                @endif
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-2 whitespace-nowrap border-x border-black text-sm">
                                        @php
                                            // Memeriksa status surat dari tabel surat
                                            $statusSurat = $surat->status;

                                            // Memeriksa apakah status surat adalah 'Diterima' di tabel pivot ruangans
                                            $statusDiterima = $surat->ruangans->contains(function ($ruangan) {
                                                return $ruangan->pivot->status === 'diterima';
                                            });

                                            // Memeriksa apakah status surat adalah 'Ditolak' di tabel pivot ruangans
                                            $statusDitolak = $surat->ruangans->contains(function ($ruangan) {
                                                return $ruangan->pivot->status === 'ditolak';
                                            });
                                        @endphp

                                        {{-- Menampilkan tombol Print Out jika status sesuai --}}
                                        @if ($statusSurat === 'ditolak' || $statusDiterima || $statusDitolak)
                                            <a href="{{ route('pdf', ['surat_id' => $surat->id]) }}"
                                                class="text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-3 py-2 text-center"
                                                target="_blank">Print Out</a>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
        <div class="my-5">
            {{ $suratList->withQueryString()->links('pagination::tailwind') }}
        </div>
    </div>
    <!-- ContentReal End -->
    </div>


    <script>
        function openPdfPreview(pdfUrl) {
            window.open(pdfUrl, '_blank');
        }
    </script>

@endsection
