@extends('layouts.mainlayout-jaringan')

@section('title', 'Jaringan-Peminjaman')
@section('page', 'Peminjaman')

@section('content')

    <div class="w-[90%] h-[90%] mx-auto flex justify-center pt-3 relative ">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-putihan rounded-lg shadow-all-side">
                <div class="flex items-center p-4 border-b border-gray-700 rounded-t">
                    <a href="{{ route('peminjaman_jaringan') }}"><button type="button"
                            class="text-gray-600 bg-transparent hover:bg-gray-300 hover:text-gray-900 rounded-lg text-sm w-8 h-8 me-2 inline-flex justify-center items-center transition-all duration-200 ease-in-out">
                            <i class='bx bx-arrow-back text-xl'></i>
                            <span class="sr-only">Close modal</span>
                        </button></a>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Surat Pengajuan
                    </h3>
                </div>
                <div class="p-4 md:p-5 space-y-4">

                    {{-- {{ $peminjamanStatus }} --}}

                    {{-- <div class="flex">
                        <div class="flex flex-col z-10">
                            <span class="block mt-3 mx-3 text-base font-semibold">Nomor Surat</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">Asal Surat</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">Nama Peminjam</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">Lama Peminjaman</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">Alasan Penolakan</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">Detail Peminjaman</span>
                            @if ($peminjamanStatus->contains('ditolak koordinator'))
                                <span class="block mt-3 mx-3 text-base font-semibold">Ruang Dipinjam</span>
                            @endif
                        </div>
                        <div class="flex flex-col z-10">
                            <span class="block mt-3 mx-3 text-base font-semibold">:</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">:</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">:</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">:</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">:</span>

                            <span class="block mt-3 mx-3 text-base font-semibold">:</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">:</span>
                        </div>

                        <div class="flex flex-col z-10">
                            <span class="block mt-3 mx-3 text-base font-semibold">{{ $suratList->nomor_surat }}</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">{{ $suratList->asal_surat }}</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">{{ $suratList->nama_peminjam }}</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">
                                {{ $suratList->jml_hari . ' hari' }}
                            </span>

                            <span class="block mt-3 mx-3 text-base font-semibold">{{ $suratList->alasan_penolakan }}</span>
                            <span class="block mt-3 mx-8 text-base font-semibold">
                                @foreach ($suratList->detailPeminjaman as $tgl)
                                    <ul class="list-disc">
                                        <li>{{ \Carbon\Carbon::parse($tgl->tanggal_peminjaman)->format('d F Y') . ' - ' . $tgl->jml_ruang . ' ruang.' }}
                                        </li>
                                    </ul>
                                @endforeach
                            </span>
                            <span class="block mt-3 mx-8 text-base font-semibold">
                                @foreach ($suratList->ruangans as $noruang)
                                    <ul class="list-disc">
                                        <li>{{ $noruang->nomor_ruang }}</li>
                                    </ul>
                                @endforeach
                            </span>
                        </div>
                    </div> --}}

                    <div class="p-4 md:p-5 space-y-4">
                        <div class="space-y-3">
                            <div class="flex">
                                <span class="block text-base font-semibold w-1/3">Nomor Surat</span>
                                <span class="block text-base font-semibold w-10">:</span>
                                <span class="block text-base font-semibold w-2/3">{{ $suratList->nomor_surat }}</span>
                            </div>
                            <div class="flex">
                                <span class="block text-base font-semibold w-1/3">Asal Surat</span>
                                <span class="block text-base font-semibold w-10">:</span>
                                <span class="block text-base font-semibold w-2/3">{{ $suratList->asal_surat }}</span>
                            </div>
                            <div class="flex">
                                <span class="block text-base font-semibold w-1/3">Nama Peminjam</span>
                                <span class="block text-base font-semibold w-10">:</span>
                                <span class="block text-base font-semibold w-2/3">{{ $suratList->nama_peminjam }}</span>
                            </div>
                            <div class="flex">
                                <span class="block text-base font-semibold w-1/3">Lama Peminjaman</span>
                                <span class="block text-base font-semibold w-10">:</span>
                                <span class="block text-base font-semibold w-2/3">{{ $suratList->jml_hari . ' hari' }}</span>
                            </div>
                            @if ($peminjamanStatus->contains('ditolak koordinator'))
                            <div class="flex">
                                <span class="block text-base font-semibold w-1/3">Alasan Penolakan</span>
                                <span class="block text-base font-semibold w-10">:</span>
                                <span class="block text-base font-semibold w-2/3 text-wrap">{{ $suratList->alasan_penolakan }}</span>
                            </div>
                            @endif
                            <div class="flex">
                                <span class="block text-base font-semibold w-1/3">Detail Peminjaman</span>
                                <span class="block text-base font-semibold w-10">:</span>
                                <span class="block text-base font-semibold w-2/3">
                                    <ul class="list-disc pl-5">
                                        @foreach ($suratList->detailPeminjaman as $tgl)
                                            <li>{{ \Carbon\Carbon::parse($tgl->tanggal_peminjaman)->format('d F Y') . ' - ' . $tgl->jml_ruang . ' ruang.' }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </span>
                            </div>
                            @if ($peminjamanStatus->contains('ditolak koordinator'))
                                <div class="flex">
                                    <span class="block text-base font-semibold w-1/3">Ruang Dipinjam</span>
                                    <span class="block text-base font-semibold w-10">:</span>
                                    <span class="block text-base font-semibold w-2/3">
                                        <ul class="list-disc pl-5">
                                            @foreach ($suratList->ruangans as $noruang)
                                                <li>{{ $noruang->nomor_ruang }}</li>
                                            @endforeach
                                        </ul>
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="flex items-center ps-8 p-4 rounded-b">
                    <a href="{{ asset('storage/file_surat/' . $suratList->file_surat) }}" data-modal-hide="static-modal"
                        type="button" target="_blank"
                        class="bg-gray-300 hover:bg-gray-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-5 py-2.5 text-center transition-all duration-200 ease-in-out">Surat
                        Pengajuan</a>
                </div>
            </div>

        </div>
    </div>





    </div>
    </div>
    </div>

@endsection
