@extends('layouts.mainlayout-ka')

@section('title', 'Pengajuan Surat')

@section('content')

    <div class="w-[90%] h-[90%] mx-auto flex justify-center pt-3">
        <div class="flex flex-col mx-5">
            <div class="-m-1.5 overflow-hidden">
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
                                            <span>{{ $loop->iteration }}</span>
                                        </th>
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base
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
