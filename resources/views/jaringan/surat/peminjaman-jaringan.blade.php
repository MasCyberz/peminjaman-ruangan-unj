    @extends('layouts.mainlayout-jaringan')

    @section('title', 'Jaringan-Peminjaman')
    @section('page', 'Peminjaman')

    @section('content')

        <div class="w-[90%] flex mx-auto px-5 mt-5 pe-4">

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

            <div class="flex my-2 gap-2 p-3">
                <span>Show</span>
                <div class="">
                    <form id="filterForm" action="{{ route('peminjaman_jaringan') }}" method="GET" class="mx-auto">
                        <label for="numero"></label>
                        <select name="numero" id="numero"
                            class="outline-none py-1 px-2 text-center border border-gray-300 shadow-[0_0px_5px_1px_rgba(0,0,0,0.2)]">
                            @if ($numero)
                                <option value="{{ $numero }}">{{ $numero }}</option>
                            @else
                                <option value="10">10</option>
                            @endif
                            @for ($i = 1; $i <= 10; $i++)
                                @if ($numero != $i)
                                    <option value={{ $i }}>{{ $i }}</option>
                                @endif
                            @endfor
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
                <label for="default-search" class="text-sm font-medium text-gray-900 sr-only">Search</label>
                <div class="relative">
                    <input type="text" name="keyword" id="default-search"
                        class="block w-full p-1.5 ps-2 text-base font-medium text-gray-900 border border-gray-300 rounded-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500 focus:outline-none"
                        placeholder="Search" />
                    <button type="submit"
                        class="text-white flex items-center absolute end-0 bottom-0 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-e-full text-sm px-4 py-2 hover:bg-gray-300">
                        <svg class="w-5 h-5 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 20">
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
                                            <th scope="col"
                                                class="px-6 py-3 whitespace-nowrap border border-gray-400 text-center text-lg font-semibold uppercase">
                                                Status</th>
                                        </tr>
                                </thead>
                                <tbody class="">
                                    @foreach ($suratList as $surat)
                                        <tr class="font-bold text-start {{  in_array($surat->id, $peminjaman) ? 'font-bold text-slate-400' : '' }}">
                                            <td
                                                class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base">
                                                <span>{{ $surat->nomor_surat }}</span>
                                                <span>{{ $surat->asal_surat }}</span>
                                            </td>
                                            <td
                                                class="px-6 py-2 border-b whitespace-nowrap border-x border-gray-400 text-base text-center transition-all duration-300 ease-in-out">
                                                <a href="/jaringan/detail-surat/{{ $surat->id }}"
                                                    class="bg-left-bottom bg-gradient-to-r text-red-600 from-red-500 to-red-500 bg-[length:0%_2px] bg-no-repeat hover:bg-[length:100%_2px] transition-all duration-500 ease-out cursor-pointer mx-3">Details</a>
                                                @if (!in_array($surat->id, $peminjaman))
                                                <a href="{{ route('ajukan_peminjaman_jaringan', $surat->id) }}"
                                                    class="bg-left-bottom bg-gradient-to-r text-green-600 from-green-500 to-green-500 bg-[length:0%_2px] bg-no-repeat hover:bg-[length:100%_2px] transition-all duration-500 ease-out cursor-pointer">Ajukan
                                                    Ruangan</a>   
                                                @endif
                                                
                                            </td>
                                            <td class="px-6 py-2 whitespace-nowrap border-b border-x border-black text-sm">
                                                @if ($suratSelesai->contains($surat->id))
                                                <div class="w-full h-full px-3 py-2 rounded-full uppercase text-center bg-slate-300 text-white">
                                                    Tdk bisa diubah.
                                               </div>

                                               @else
                                               <div class="w-full h-full px-3 py-2 rounded-full uppercase text-center bg-green-100 text-green-800">
                                                    Diterima Oleh KA.
                                               </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="my-5">
                            {{ $suratList->withQueryString()->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
            {{-- table atas end --}}



            {{-- <div class="flex justify-center my-4">
                <nav class="inline-flex">
                    <ul class="flex items-center">
                        Tombol "Previous"
                        @if ($suratList->onFirstPage())
                            <li>
                                <span class="bg-gray-300 px-2 py-1 mr-1 rounded-md cursor-not-allowed">&laquo;</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $suratList->previousPageUrl() }}"
                                    class="bg-blue-500 text-white px-2 py-1 mr-1 rounded-md">&laquo;</a>
                            </li>
                        @endif

                        Loop untuk menampilkan tombol-tombol pagination
                        @foreach ($suratList->getUrlRange(1, $suratList->lastPage()) as $page => $url)
                            <li>
                                <a href="{{ $url }}"
                                    class="{{ $page == $suratList->currentPage() ? 'bg-blue-500 text-white' : 'bg-gray-300 text-black' }} px-2 py-1 mr-1 rounded-md">{{ $page }}</a>
                            </li>
                        @endforeach

                        Tombol "Next"
                        @if ($suratList->hasMorePages())
                            <li>
                                <a href="{{ $suratList->nextPageUrl() }}"
                                    class="bg-blue-500 text-white px-2 py-1 mr-1 rounded-md">&raquo;</a>
                            </li>
                        @else
                            <li>
                                <span class="bg-gray-300 px-2 py-1 mr-1 rounded-md cursor-not-allowed">&raquo;</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div> --}}



            {{-- Table Bawah start --}}
            


        {{-- Modal Tombol Detail start --}}



    @endsection
