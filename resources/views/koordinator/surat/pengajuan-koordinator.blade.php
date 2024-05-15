@extends('layouts.mainlayout-koordinator')

@section('title', 'Koordinator-Pengajuan')
@section('page', 'Pengajuan')

@section('content')

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

    <div class="w-[90%] h-full mx-auto pt-5 px-20">
        <span class="font-bold text-2xl pb-1 border-b border-gray-600">Pengajuan Ruang</span>
        <div class="overflow-hidden mt-8">
            {{-- <table class="text-gray-900 w-[90%]">
                <tbody class="border-y border-gray-400 text-left">
                    <tr class="">
                        <form action="">
                            <th class="px-6 py-3 border-s border-e border-gray-400">
                                Ruangan 301 (20pc)
                            </th>
                            <td class="px-6 py-3 border-e border-gray-400 text-white block gap-2">
                                <button
                                    class="bg-red-500 px-5 py-2 rounded-lg hover:bg-red-600 transition-all duration-300 ease-in-out">
                                    Tolak
                                </button>
                                <button
                                    class="bg-green-500 px-4 py-2 rounded-lg hover:bg-green-600 transition-all duration-300 ease-in-out">
                                    Terima
                                </button>
                            </td>
                        </form>
                    </tr>
                </tbody>
            </table> --}}
            @foreach ($permintaanRuang as $surat)
                <table class="text-gray-900 w-[90%] table-fixed">
                    <tbody class="border-y border-gray-400 text-left">
                        @php
                            $firstRuangan = $surat->ruangans->first();
                            $status = optional(optional($firstRuangan)->pivot)->status;
                        @endphp
                        <tr class="{{ $status == 'pending' ? '' : 'text-slate-500 bg-slate-200' }}">
                            <th class="px-6 py-2 border-s border-e border-gray-400 leading-loose font-medium">
                                Nomor Surat : {{ $surat->nomor_surat }}
                            </th>
                            <td class="px-6 py-2 border-e border-gray-400 text-white flex items-center">
                                @if ($status == 'pending')
                                    <form action="{{ route('pengajuan_store_koordinator', ['suratId' => $surat->id]) }}"
                                        method="POST">
                                        @csrf
                                        <button type="button" data-modal-target="tolak-modal{{ $surat->id }}"
                                            data-modal-toggle="tolak-modal{{ $surat->id }}" class="">
                                            <span
                                                class="bg-red-500 mx-2 px-4 py-2 rounded-lg hover:bg-red-600 transition-all duration-300 ease-in-out">Tolak</span>
                                        </button>
                                    </form>
                                    <button type="button" data-modal-target="terima-modal{{ $surat->id }}"
                                        data-modal-toggle="terima-modal{{ $surat->id }}" class="">
                                        <span
                                            class="bg-green-500 mx-2 px-4 py-2 rounded-lg hover:bg-green-600 transition-all duration-300 ease-in-out">Terima</span>
                                    </button>
                                    {{-- <button data-modal-target="detail-modal{{ $surat->id }}"
                                        data-modal-toggle="detail-modal{{ $surat->id }}" type="button"
                                        class="px-4 py-2 mx-2 rounded-lg cursor-pointer">
                                        <span
                                            class="bg-left-bottom text-red-500 bg-gradient-to-r from-red-500 to-red-500 bg-[length:0%_2px] bg-no-repeat hover:bg-[length:100%_2px] transition-all duration-1000 ease-in-out ">Details</span>
                                    </button> --}}
                                    <a href="{{ route('detail_peminjaman_koordinator', ['suratId' => $surat->id]) }}"><button
                                            data-modal-target="detail-modal{{ $surat->id }}"
                                            data-modal-toggle="detail-modal{{ $surat->id }}" type="button"
                                            class="px-4 py-2 mx-2 rounded-lg cursor-pointer">
                                            <span
                                                class="bg-left-bottom text-red-500 bg-gradient-to-r from-red-500 to-red-500 bg-[length:0%_2px] bg-no-repeat hover:bg-[length:100%_2px] transition-all duration-1000 ease-in-out ">Details</span>
                                        </button>
                                    </a>
                                @else
                                    <a href="{{ route('detail_peminjaman_koordinator', ['suratId' => $surat->id]) }}"><button
                                            data-modal-target="detail-modal{{ $surat->id }}"
                                            data-modal-toggle="detail-modal{{ $surat->id }}" type="button"
                                            class="px-4 py-2 mx-2 rounded-lg cursor-pointer">
                                            <span
                                                class="bg-left-bottom text-red-500 bg-gradient-to-r from-red-500 to-red-500 bg-[length:0%_2px] bg-no-repeat hover:bg-[length:100%_2px] transition-all duration-1000 ease-in-out ">Details</span>
                                        </button>
                                    </a>

                                    <span class="text-black">sudah direspon</span>
                                @endif
                                {{-- <a href="{{ route('detail_peminjaman_koordinator', ['suratId' => $surat->id]) }}">test</a> --}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endforeach
        </div>

    </div>


    <!-- Main modal-Terima -->
    @foreach ($permintaanRuang as $surat)
        <div id="terima-modal{{ $surat->id }}" tabindex="-1"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <button type="button"
                        class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-hide="terima-modal{{ $surat->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-4 md:p-5 text-center">
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500">Apakah anda yakin ingin menyetujui ruang ini?
                        </h3>
                        <form action="{{ route('pengajuan_store_koordinator', ['suratId' => $surat->id]) }}"
                            method="POST">
                            @csrf
                            <button data-modal-hide="terima-modal{{ $surat->id }}" type="button"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Kembali</button>
                            <button data-modal-hide="terima-modal{{ $surat->id }}" type="submit" name="status"
                                value="diterima"
                                class="text-white bg-green-400 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Ya, Terima
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Tolak --}}

    @foreach ($permintaanRuang as $surat)
        <div id="tolak-modal{{ $surat->id }}" tabindex="-1"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <button type="button"
                        class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-hide="tolak-modal{{ $surat->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-4 md:p-5 text-center">
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500">Apakah anda yakin ingin menolak permintaan ruang
                            ini?</h3>
                        <form action="{{ route('pengajuan_store_koordinator', ['suratId' => $surat->id]) }}"
                            method="POST">
                            @csrf

                            <textarea id="alasan_penolakan" name="alasan_penolakan" rows="4"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent mb-3"
                                placeholder="Tulis alasan penolakan di sini...
Contoh : Terdapat perbaikan ruangan"></textarea>
                            <button data-modal-hide="tolak-modal{{ $surat->id }}" type="button"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Kembali</button>
                            <button data-modal-hide="tolak-modal{{ $surat->id }}" type="submit" name="status"
                                value="ditolak"
                                class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Ya, Tolak
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Main modal-Detail -->
    {{-- @foreach ($permintaanRuang as $surat)
        <div id="detail-modal{{ $surat->id }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between px-5 py-3 border-b rounded-t">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Detail Pengajuan
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-hide="detail-modal{{ $surat->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->

                    <div class="py-1.5 px-5 space-y-4">
                        <div class="flex gap-2">
                            <h2 class="text-lg whitespace-nowrap">Detail Pengajuan :</h2>
                            <div class="text-lg space-y-4 flex flex-col mx-2">
                                <ul>
                                        <span class="font-medium">Tanggal:
                                            {{ \Carbon\Carbon::parse($data['tanggal_peminjaman'])->format('d F Y') }}</span>
                                            <li class="list-disc mx-4">{{ 'Ruangan : ' . $ruang['nomor_ruang'] }}</li>
                                    </ul>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-center py-3 px-5 border-t border-gray-200 rounded-b">
                        @if ($surat->ruangans->first()->pivot->status == 'pending')
                            <div class="bg-yellow-200 px-3 py-2 rounded-lg">
                                <span class="">Status :
                                    <span class="uppercase">
                                        Disetujui oleh KA dan Jaringan
                                    </span>
                                @else
                                    <div class="bg-green-200 px-3 py-2 rounded-lg">
                                        <span class="uppercase">
                                            Selesai Disetujui Oleh Koordinator.
                                        </span>
                                    </div>
                        @endif
                        </span>
                    </div>

                </div>
            </div>
        </div>
        </div>
    @endforeach --}}
@endsection
