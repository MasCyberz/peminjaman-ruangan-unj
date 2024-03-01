@extends('layouts.mainlayout-koordinator')

@section('title', 'Koordinator-Pengajuan')
@section('page', 'Pengajuan')

@section('content')

    <div class="w-[90%] h-full mx-auto pt-5 px-20">
        <span class="font-bold text-2xl pb-1 border-b border-gray-600">Pengajuan Ruang</span>



        <div class="overflow-hidden mt-8">
            <table class="text-gray-900 w-[90%]">
                <tbody class="border-y border-gray-400 text-left">
                    <tr class="">
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
                    </tr>
                </tbody>
            </table>
        </div>

    </div>


@endsection
