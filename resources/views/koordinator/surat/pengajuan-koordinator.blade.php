@extends('layouts.mainlayout-koordinator')

@section('title', 'Koordinator-Pengajuan')
@section('page', 'Pengajuan')

@section('content')

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
                        <tr class="">
                            <th class="px-6 py-2 border-s border-e border-gray-400 leading-loose font-medium">
                                No : {{ $surat->nomor_surat }}
                            </th>
                            <td class="px-6 py-2 border-e border-gray-400 text-white flex items-center">
                                <form action="{{ route('pengajuan_store_koordinator', ['suratId' => $surat->id]) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit" name="status" value="Ditolak"
                                        class="bg-red-500 mx-2 px-5 py-2 rounded-lg hover:bg-red-600 transition-all duration-300 ease-in-out">
                                        Tolak
                                    </button>
                                    <button type="submit" name="status" value="Diterima"
                                        class="bg-green-500 mx-2 px-4 py-2 rounded-lg hover:bg-green-600 transition-all duration-300 ease-in-out">
                                        Terima
                                    </button>
                                </form>
                                <button data-modal-target="detail-modal{{ $surat->id }}" data-modal-toggle="detail-modal{{ $surat->id }}" type="button"
                                    class="px-4 py-2 mx-2 rounded-lg bg-left-bottom text-red-500 bg-gradient-to-r from-red-500 to-red-500 bg-[length:0%_2px] bg-no-repeat hover:bg-[length:100%_2px] transition-all duration-500 ease-out cursor-pointer">
                                    Details
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endforeach
        </div>

    </div>



    <!-- Main modal -->
    @foreach ($permintaanRuang as $surat)
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
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->

                <div class="py-1.5 px-5 space-y-4">
                    <div class="flex gap-2">
                        <h2 class="text-lg whitespace-nowrap">Ruangan yang di request :</h2>
                        <div class="text-lg space-y-4 flex flex-col mx-2">
                            @foreach ($surat->ruangans as $ruangan)
                            <span>Ruangan : {{ $ruangan->nomor_ruang }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-center py-3 px-5 border-t border-gray-200 rounded-b">
                    <div class="bg-yellow-200 px-3 py-2 rounded-lg">
                        <span class="">Status :
                            <span class="uppercase">{{ $ruangan->pivot->status }}
                            </span>
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endforeach


@endsection
