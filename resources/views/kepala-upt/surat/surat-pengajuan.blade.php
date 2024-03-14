@extends('layouts.mainlayout-ka')

@section('title', 'Pengajuan Surat')

@section('content')

    <div class="w-[90%] h-[90%] mx-auto flex justify-center pt-3">
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
        <div class="flex flex-col mx-5 w-[80%]">
            <div class="-m-1.5">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-400">
                            <thead>
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 sticky top-0 whitespace-nowrap border border-gray-400 text-center text-lg font-semibold uppercase">
                                        No .</th>
                                    <th scope="col"
                                        class="px-6 py-3 sticky top-0 whitespace-nowrap border border-gray-400 text-center text-lg font-semibold uppercase">
                                        Surat Peminjaman</th>
                                    <th scope="col"
                                        class="px-6 py-3 sticky top-0 whitespace-nowrap border border-gray-400 text-center text-lg font-semibold uppercase">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="">
                                @foreach ($suratList as $surat)
                                    <tr class="font-medium text-left">
                                        <th
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-center text-base
                                    @if ($surat->status == 'diterima' || $surat->status == 'ditolak') text-slate-400 font-normal @endif">
                                            <span>{{ $loop->iteration + $suratList->firstItem() - 1 }}</span>
                                        </th>
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center
                                        @if ($surat->status == 'diterima' || $surat->status == 'ditolak') text-slate-400 font-normal @endif">
                                            <span>{{ $surat->nomor_surat . ' | ' . $surat->asal_surat }}</span>
                                        </td>
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center text-red-600 transition-all duration-300 ease-in-out">
                                            @if ($surat->status == 'diterima' || $surat->status == 'ditolak')
                                                <a href="{{ route('detail_peminjaman_kepala_upt', [$surat->id]) }}"
                                                    id="detailButton_{{ $surat->id }}"
                                                    class="bg-left-bottom bg-gradient-to-r from-red-500 to-red-500 bg-[length:0%_2px] bg-no-repeat hover:bg-[length:100%_2px] transition-all duration-500 ease-out opacity-50">
                                                    Details
                                                </a>
                                            @else
                                                <a href="{{ route('detail_peminjaman_kepala_upt', [$surat->id]) }}"
                                                    class="bg-left-bottom bg-gradient-to-r from-red-500 to-red-500 bg-[length:0%_2px] bg-no-repeat hover:bg-[length:100%_2px] transition-all duration-500 ease-out">
                                                    Details
                                                </a>
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
                {{ $suratList->links('pagination::tailwind') }}
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
