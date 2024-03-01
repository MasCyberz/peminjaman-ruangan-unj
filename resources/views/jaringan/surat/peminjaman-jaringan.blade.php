@extends('layouts.mainlayout-jaringan')

@section('title', 'Jaringan-Peminjaman')
@section('page', 'Peminjaman')

@section('content')

    <div class="w-[90%] flex mx-auto px-5 mt-5 pe-4">
        <div class="flex my-2 gap-2 p-3">
            <span>Show</span>
            <div class="border-2 border-gray-300 w-[50px]">
                <form id="filterForm" action="{{ url('peminjaman_jaringan') }}" method="GET" class="mx-auto">
                    <label for="numero"></label>
                    <select name="numero" id="numero"
                        class="outline-none py-1 px-2 text-end border border-gray-300 shadow-[0_0px_5px_1px_rgba(0,0,0,0.2)]">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </form>
            </div>
            <span>entries</span>
        </div>

        <script>
            document.getElementById("numero").addEventListener("change", function() {
                document.getElementById("filterForm").submit();
            });
        </script>


        <form class="max-w-md ms-auto my-auto" action="" method="GET">
            @csrf
            <label for="default-search" class="text-sm font-medium text-gray-900 sr-only">Search</label>
            <div class="relative">
                <input type="text" name="keyword" id="default-search"
                    class="block w-full p-1.5 ps-2 text-base font-medium text-gray-900 border border-gray-300 rounded-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500 focus:outline-none"
                    placeholder="Search" required />
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

    {{-- table atas start --}}
    <div class="w-[90%] h-1/2 mx-auto my-auto">
        <div class="flex flex-col mx-5">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="overflow-hidden">
                        <table class="min-w-full border border-gray-400">
                            <thead>
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 whitespace-nowrap border border-gray-400 text-center text-lg font-semibold uppercase">
                                        Surat Peminjaman</th>
                                    <th scope="col"
                                        class="px-6 py-3 whitespace-nowrap border border-gray-400 text-center text-lg font-semibold uppercase">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="">
                                @foreach ($suratList as $surat)
                                    <tr class="font-bold text-start">
                                        <td class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base">
                                            <span>{{ $surat->nomor_surat }}</span>
                                            <span>{{ $surat->asal_surat }}</span>
                                        </td>
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center text-red-600 transition-all duration-300 ease-in-out">
                                            <a href="/jaringan/detail-surat/{{ $surat->id }}"
                                                class="bg-left-bottom bg-gradient-to-r from-red-500 to-red-500 bg-[length:0%_2px] bg-no-repeat hover:bg-[length:100%_2px] transition-all duration-500 ease-out cursor-pointer">Details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- table atas end --}}


        {{-- Table Bawah start --}}
        <div class="w-full h-1/2 mx-auto mt-10">
            <div class="flex flex-col mx-5">
                <div class="-m-1.5 overflow-y-visible">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full border border-gray-400">
                                <thead>
                                    <tr>
                                        <th rowspan="2" scope="col"
                                            class="px-0 mx-0 py-2 whitespace-nowrap border border-gray-400 text-center text-lg font-bold uppercase">
                                            Nomor Ruangan</th>
                                        <th colspan="2" scope="col"
                                            class="px-6 py-2 whitespace-nowrap border border-gray-400 text-center text-lg font-bold uppercase">
                                            Kapasitas</th>
                                        <th rowspan="2" scope="col"
                                            class="px-6 py-2 whitespace-nowrap border border-gray-400 text-center text-lg font-bold uppercase">
                                            Status</th>
                                        <th rowspan="2" scope="col"
                                            class="px-6 py-2 whitespace-nowrap border border-gray-400 text-center text-lg font-bold uppercase">
                                            Aksi</th>
                                    </tr>
                                    <tr class="">
                                        <th scope="col" class="border border-gray-400 px-0 mx-0 py-2">Orang</th>
                                        <th scope="col" class="border border-gray-400 mx-0 px-0 py-2">PC</th>
                                    </tr>
                                </thead>
                                <tbody class="">
                                    <tr class="font-semibold text-start">
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            301
                                        </td>
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            20
                                        </td>
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            20
                                        </td>
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            Kosong
                                        </td>
                                        <td
                                            class="px-2 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center text-white transition-all duration-300 ease-in-out">
                                            <button
                                                class="px-6 py-1.5 bg-green-500 rounded-lg hover:bg-green-600 transition-all duration-300 ease-in-out">
                                                Ajukan
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="font-semibold text-start">
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            302
                                        </td>
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            20
                                        </td>
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            20
                                        </td>
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            Kosong
                                        </td>
                                        <td
                                            class="px-2 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center text-white transition-all duration-300 ease-in-out">
                                            <button
                                                class="px-6 py-1.5 bg-green-500 rounded-lg hover:bg-green-600 transition-all duration-300 ease-in-out">
                                                Ajukan
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="font-semibold text-start">
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            303
                                        </td>
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            20
                                        </td>
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            20
                                        </td>
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            Kosong
                                        </td>
                                        <td
                                            class="px-2 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center text-white transition-all duration-300 ease-in-out">
                                            <button
                                                class="px-6 py-1.5 bg-green-500 rounded-lg hover:bg-green-600 transition-all duration-300 ease-in-out">
                                                Ajukan
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="font-semibold text-start">
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            304
                                        </td>
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            20
                                        </td>
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            20
                                        </td>
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            Kosong
                                        </td>
                                        <td
                                            class="px-2 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center text-white transition-all duration-300 ease-in-out">
                                            <button
                                                class="px-6 py-1.5 bg-green-500 rounded-lg hover:bg-green-600 transition-all duration-300 ease-in-out">
                                                Ajukan
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="font-semibold text-start">
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            305
                                        </td>
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            20
                                        </td>
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            20
                                        </td>
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            Kosong
                                        </td>
                                        <td
                                            class="px-2 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center text-white transition-all duration-300 ease-in-out">
                                            <button
                                                class="px-6 py-1.5 bg-green-500 rounded-lg hover:bg-green-600 transition-all duration-300 ease-in-out">
                                                Ajukan
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="font-semibold text-start">
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            306
                                        </td>
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            20
                                        </td>
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            20
                                        </td>
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            Kosong
                                        </td>
                                        <td
                                            class="px-2 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center text-white transition-all duration-300 ease-in-out">
                                            <button
                                                class="px-6 py-1.5 bg-green-500 rounded-lg hover:bg-green-600 transition-all duration-300 ease-in-out">
                                                Ajukan
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="font-semibold text-start">
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            307
                                        </td>
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            20
                                        </td>
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            20
                                        </td>
                                        <td
                                            class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center">
                                            Kosong
                                        </td>
                                        <td
                                            class="px-2 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center text-white transition-all duration-300 ease-in-out">
                                            <button
                                                class="px-6 py-1.5 bg-green-500 rounded-lg hover:bg-green-600 transition-all duration-300 ease-in-out">
                                                Ajukan
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- table bawah end --}}
    </div>


    {{-- Modal Tombol Detail start --}}









@endsection
