@extends('layouts.mainlayout-ka')

@section('title', 'Pengajuan Surat')

@section('content')

    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
            <div class="grid sm:grid-cols-1 2xl:grid-cols-2 gap-10">
                <div class="mb-6">
                    <h1 class="text-3xl text-black font-bold dark:text-gray-500">Surat Pengajuan</h1>
                </div>

            </div>

            @if (session('success'))
                <div class="w-full p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                    role="alert">
                    <span class="font-medium text-base">{{ session()->get('success') }}</span>
                </div>
            @endif


            <div class="grid sm:grid-cols-1 relative  rounded dark:bg-gray-800">
                <div class=" 2xl:overflow-x-auto md:overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Surat Peminjaman
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suratList as $surat)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white
                                        @if ($surat->status == 'diterima' || $surat->status == 'ditolak') text-slate-400 font-normal @endif">
                                        {{ $loop->iteration }}
                                    </th>
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white
                                        @if ($surat->status == 'diterima' || $surat->status == 'ditolak') text-slate-400 font-normal @endif">
                                        {{ $surat->nomor_surat }} | {{ $surat->asal_surat }}
                                    </th>
                                    <td class="flex items-center px-6 py-4">
                                        @if ($surat->status == 'diterima' || $surat->status == 'ditolak')
                                            <a id="detailButton_{{ $surat->id }}"
                                                href="{{ route('detail_peminjaman_kepala_upt', [$surat->id]) }}"
                                                class="font-medium text-red-400 dark:text-red-300 hover:underline ms-3 opacity-50">Detail</a>
                                        @else
                                            <a href="{{ route('detail_peminjaman_kepala_upt', [$surat->id]) }}"
                                                class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">Detail</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function disableLink(buttonId) {
            var detailButton = document.getElementById(buttonId);
            detailButton.removeEventListener('click', handleClick);
            detailButton.classList.add('cursor-not-allowed', 'opacity-50');
            detailButton.removeAttribute('href');
        }

        function handleClick(event) {
            var buttonId = event.target.id;
            disableLink(buttonId);
        }

        document.addEventListener('DOMContentLoaded', function() {
            var detailButtons = document.querySelectorAll('[id^="detailButton_"]');
            detailButtons.forEach(function(button) {
                button.addEventListener('click', handleClick);
            });
        });
    </script>

@endsection
