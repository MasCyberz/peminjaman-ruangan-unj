@extends('layouts.mainlayout-ka')

@section('title', 'Detail Surat')
@section('page', 'Detail Surat')

@section('content')

    <div class="w-[90%] h-[90%] mx-auto flex justify-center pt-3 relative ">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-putihan rounded-lg shadow-all-side">
                <div class="flex items-center p-4 border-b border-gray-700 rounded-t">
                    <a href="{{ route('peminjaman_kepala_upt') }}"><button type="button"
                            class="text-gray-600 bg-transparent hover:bg-gray-300 hover:text-gray-900 rounded-lg text-sm w-8 h-8 me-2 inline-flex justify-center items-center transition-all duration-200 ease-in-out">
                            <i class='bx bx-arrow-back text-xl'></i>
                            <span class="sr-only">Close modal</span>
                        </button></a>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Surat Pengajuan
                    </h3>
                </div>
                <div class="p-4 md:p-5 space-y-4">
                    <div class="flex">
                        <div class="flex flex-col z-10">
                            <span class="block mt-3 mx-3 text-base font-semibold">Nomor Surat</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">Asal Surat</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">Nama Peminjam</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">Lama Peminjaman</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">Status Surat</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">
                                @php
                                $tolakStatusDitemukan = false;
                            @endphp

                            @foreach ($pengajuanList->ruangans as $item)
                                @if ($item->pivot->status == 'jaringan menerima tolakan koordinator')
                                    @php
                                        $tolakStatusDitemukan = true;
                                    @endphp
                                @endif
                            @endforeach

                            @if ($tolakStatusDitemukan)
                                Alasan Penolakan
                            @endif
                            </span>
                            <span class="block mt-3 mx-3 text-base font-semibold">Detail Pinjaman</span>
                        </div>
                        <div class="flex flex-col z-10">
                            <span class="block mt-3 mx-3 text-base font-semibold">:</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">:</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">:</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">:</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">:</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">
                                @php
                                $tolakStatusDitemukan = false;
                            @endphp

                            @foreach ($pengajuanList->ruangans as $item)
                                @if ($item->pivot->status == 'jaringan menerima tolakan koordinator')
                                    @php
                                        $tolakStatusDitemukan = true;
                                    @endphp
                                @endif
                            @endforeach

                            @if ($tolakStatusDitemukan)
                                :
                            @endif
                            </span>
                            <span class="block mt-3 mx-3 text-base font-semibold">:</span>
                        </div>
                        <div class="flex flex-col z-10">

                            <span class="block mt-3 mx-3 text-base font-semibold">{{ $pengajuanList->nomor_surat }}</span>

                            <span class="block mt-3 mx-3 text-base font-semibold">{{ $pengajuanList->asal_surat }}</span>

                            <span class="block mt-3 mx-3 text-base font-semibold">{{ $pengajuanList->nama_peminjam }}</span>

                            <span class='block mt-3 mx-3 text-base font-semibold'>
                                {{ $pengajuanList->jml_hari . ' hari' }}
                            </span>

                            <span class="block mt-3 mx-3 text-base font-semibold">
                                @php
                                    $tolakStatusDitemukan = false;
                                @endphp

                                @foreach ($pengajuanList->ruangans as $item)
                                    @if ($item->pivot->status == 'jaringan menerima tolakan koordinator')
                                        @php
                                            $tolakStatusDitemukan = true;
                                        @endphp
                                    @endif
                                @endforeach

                                @if ($tolakStatusDitemukan)
                                    Jaringan dan koordinator menolak surat ini
                                @else
                                    Surat diajukan oleh admin
                                @endif
                            </span>

                            <span
                                class="block mt-3 mx-3 text-base font-semibold">
                                @php
                                $tolakStatusDitemukan = false;
                            @endphp

                            @foreach ($pengajuanList->ruangans as $item)
                                @if ($item->pivot->status == 'jaringan menerima tolakan koordinator')
                                    @php
                                        $tolakStatusDitemukan = true;
                                    @endphp
                                @endif
                            @endforeach

                            @if ($tolakStatusDitemukan)
                                {{ $pengajuanList->alasan_penolakan }}
                            @endif
                            </span>

                            <span class="block mt-3 mx-8 text-base font-semibold">
                                @foreach ($pengajuanList->detailPeminjaman as $tgl)
                                    <ul class="list-disc">
                                        <li>{{ \Carbon\Carbon::parse($tgl->tanggal_peminjaman)->format('d F Y') . ' - ' . $tgl->jml_ruang . ' ruang.' }}
                                        </li>
                                    </ul>
                                @endforeach
                            </span>

                        </div>
                    </div>
                </div>
                <div class="flex ps-8 p-4 rounded-b relative">
                    <a href="{{ asset('storage/file_surat/' . $pengajuanList->file_surat) }}" target="_blank"
                        class="bg-gray-300 hover:bg-gray-400 focus:ring-4 focus:outline-none focus:ri   ng-blue-300 font-medium rounded-md text-sm px-5 py-2.5 text-center transition-all duration-200 ease-in-out">Surat
                        Pengajuan</a>
                    <div class="flex ms-auto">

                        @php
                            $tolakStatusDitemukan = false;
                        @endphp

                        @foreach ($pengajuanList->ruangans as $item)
                            @if ($item->pivot->status == 'jaringan menerima tolakan koordinator')
                                @php
                                    $tolakStatusDitemukan = true;
                                @endphp
                            @endif
                        @endforeach

                        @if ($tolakStatusDitemukan)
                            <button type="button" data-modal-target="terima-tolak-modal" data-modal-toggle="terima-tolak-modal"
                                class="bg-green-500 hover:bg-green-700 text-white focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-md text-sm px-5 py-2.5 ms-1.5 text-center transition-all duration-200 ease-in-out">Terima</button>
                        @elseif ($pengajuanList->status == 'pending')
                            <form id="rejectForm"
                                action="{{ route('respond_kepala_upt', ['id' => $pengajuanList->id, 'response' => 'reject']) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <button id="rejectButton" type="button"
                                    class="bg-red-500 hover:bg-red-700 text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-md text-sm px-7 py-2.5 text-center transition-all duration-200 ease-in-out">Tolak</button>
                                <div id="alasanPenolakan"
                                    class="hidden absolute right-0 top-24 items-center w-full p-10 bg-putihan rounded-lg shadow-all-side">
                                    <input type="text" name="alasan_penolakan" placeholder="Alasan penolakan"
                                        class="bg-gray-300 px-3 w-[86%] py-2 rounded-md focus:border-none focus:outline-none focus:ring-2 focus:ring-sidebarunj mr-2"
                                        required>
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-700 text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-md text-sm px-4 py-3 text-center transition-all duration-200 ease-in-out">Kirim</button>
                                </div>
                            </form>
                            <button type="button" data-modal-target="terima-modal" data-modal-toggle="terima-modal"
                                class="bg-green-500 hover:bg-green-700 text-white focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-md text-sm px-5 py-2.5 ms-1.5 text-center transition-all duration-200 ease-in-out">Terima</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Terima Tolak--}}
    <div id="terima-tolak-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="terima-tolak-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500">Apakah anda yakin ingin menyetujui penolakan surat ini?</h3>
                    <div class="flex justify-center gap-3 ">
                        <button data-modal-hide="terima-tolak-modal" type="button"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Kembali</button>
                        <form
                            action="{{ route('terima_tolak_kepala_upt', ['id' => $pengajuanList->id, 'response' => 'accept']) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <button data-modal-hide="terima-tolak-modal" type="submit"
                                class="text-white bg-green-400 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Ya, setuju
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Terima Tolak End --}}

    {{-- Modal Terima --}}
    <div id="terima-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="terima-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500">Apakah anda yakin ingin menyetujui surat ini?</h3>
                    <div class="flex justify-center gap-3 ">
                        <button data-modal-hide="terima-modal" type="button"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Kembali</button>
                        <form
                            action="{{ route('respond_kepala_upt', ['id' => $pengajuanList->id, 'response' => 'accept']) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <button data-modal-hide="terima-modal" type="submit"
                                class="text-white bg-green-400 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Ya, setuju
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Terima End --}}

    <script>
        // document.getElementById('rejectButton').addEventListener('click', function() {
        //     document.getElementById('alasanPenolakan').classList.remove('hidden');
        // });

        const rejectButton = document.getElementById('rejectButton');
        const alasanPenolakan = document.getElementById('alasanPenolakan');

        rejectButton.addEventListener('click', function() {
            if (alasanPenolakan.classList.contains('hidden')) {
                alasanPenolakan.classList.remove('hidden');
            } else {
                alasanPenolakan.classList.add('hidden');
            }
        })
    </script>

@endsection
