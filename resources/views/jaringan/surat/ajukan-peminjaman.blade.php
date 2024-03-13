@extends('layouts.mainlayout-jaringan')

@section('title', 'Pengajuan Ruang')
@section('page', 'Pengajuan Ruang')


@section('content')

    <div class="rounded-lg shadow-all-side w-[80%] my-5 p-8 mx-auto">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Whoops!</strong>
                <span class="block sm:inline">{{ $errors->first('ruangan') }}</span>
            </div>
        @endif
        <form class="mx-10" action="/jaringan/ajukan-peminjaman/store/{{ $suratList->id }}" method="POST">
            @csrf
            <div class="flex border-b-2 border-black w-full font-semibold mb-3">
                <i class='bx bx-laptop text-2xl mx-4'></i>
                <span class="text-base">Ajukan Ruang</span>
            </div>

            <div class="mb-2">
                <label for="nomor_surat" class="block mb-2 text-sm text-gray-900 font-semibold">Nomor Surat</label>
                <input type="text" id="nomor_surat" name="nomor_surat" value="{{ $suratList->nomor_surat }}"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5"
                    readonly />
            </div>
            <div class="mb-2">
                <label for="asal_surat" class="block mb-2 text-sm text-gray-900 font-semibold">Asal Surat</label>
                <input type="text" id="asal_surat" name="asal_surat" value="{{ $suratList->asal_surat }}"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5"
                    readonly />
            </div>

            <div class="mb-2">
                <input type="hidden" id="nama_peminjam" name="nama_peminjam" value="{{ $suratList->nama_peminjam }}"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5"
                    readonly />
                <input id="mulai_dipinjam" name="mulai_dipinjam" value="{{ $suratList->mulai_dipinjam }}"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5"
                    readonly />
                <input id="selesai_dipinjam" name="selesai_dipinjam" value="{{ $suratList->selesai_dipinjam }}"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5"
                    readonly />
                <input type="hidden" id="jml_pc" name="jml_pc" value="{{ $suratList->jml_pc }}"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5"
                    readonly />
                <input type="hidden" id="jml_ruang" name="jml_ruang" value="{{ $suratList->jml_ruang }}"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5"
                    readonly />
                <input type="hidden" id="status" name="status" value="{{ $suratList->status }}"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5"
                    readonly />
            </div>

            <!-- Dropdown Component -->
            <div x-data="{ open: false }" @click.away="open = false" class="relative">
                <!-- Trigger -->
                <button @click="open = !open" type="button"
                    class="px-4 py-2 mt-5 flex items-center bg-gray-200 rounded-md border border-gray-300 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    Pilih Ruangan
                    <!-- Icon -->
                    <svg :class="{ 'rotate-180': open }" class="w-4 h-4 ml-2 transform transition-transform"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <!-- Dropdown Body -->
                <div x-show="open" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute z-50 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                    <div class="py-1">
                        <!-- Options -->
                        @foreach ($ruanganTersedia as $ruangan)
                            <label
                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                <input type="checkbox" name="ruangan[]" value="{{ $ruangan->id }}"
                                    class="mr-3 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                {{ $ruangan->nomor_ruang }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex gap-2 mt-3 items-center">
                <a class="ms-auto text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-2xl text-sm sm:w-auto px-5 py-2.5 text-center shadow-[0_4px_4px_1px_rgba(0,0,0,0.3)]"
                    href="{{ route('peminjaman_jaringan') }}">Cancel</a>
                <button type="submit"
                    class="text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-2xl text-sm w-full sm:w-auto px-5 py-2.5 text-center shadow-[0_4px_4px_1px_rgba(0,0,0,0.3)]">Ajukan</button>
            </div>
        </form>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
@endsection
