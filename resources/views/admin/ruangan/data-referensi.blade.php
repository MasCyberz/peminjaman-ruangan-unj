@extends('layouts.mainlayout-admin')
@section('title', 'Data Referensi')
@section('page', 'Data Referensi')

@section('content')

    <div class="w-[calc(100%-8rem)] h-full mx-auto py-3 px-4">

        {{-- <a href="{{ route('tambah_ruangan') }}"
            class="flex items-center transition-all duration-300 ease-in-out  hover:bg-sidebarunj hover:text-white h-11 w-full py-1">
            <i data-tooltip-target="tooltip-right" data-tooltip-placement="right"
                class='bx bx-plus text-4xl rounded-b-lg text-sidebarunj font-medium '></i>
            <span class="text-xl font-semibold text-sidebarunj">Tambah Data</span>
        </a> --}}

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

        <a href="{{ route('tambah_ruangan') }}"
            class="relative text-xl left-[11.5rem] mt-2 inline-flex items-center bg-gray-500 hover:bg-slate-600 text-white py-2 px-2 rounded-lg transition-all duration-300 ease-in-out font-semibold focus:outline-none focus: focus:ring-4 focus:ring-slate-600">
            <i class='bx bx-plus text-3xl'></i>
            Tambah Data
        </a>

        @foreach ($ruanganList as $index => $ruang)
            <div class="my-5 mx-auto rounded-lg shadow-all-side h-[420px] w-[60%] flex flex-col p-3 relative">

                <div class="flex my-auto relative mx-20">
                    <div class="flex flex-col z-10">
                        <span class="block mt-3 mx-3 text-base font-semibold">Nomor Ruangan</span>
                        <span class="block mt-3 mx-3 text-base font-semibold">Nama Ruangan</span>
                        <span class="block mt-3 mx-3 text-base font-semibold">Jumlah PC</span>
                        <span class="block mt-3 mx-3 text-base font-semibold">Kapasitas Orang</span>
                        <span class="block mt-3 mx-3 text-base font-semibold">Fasilitas</span>
                    </div>
                    <div class="flex flex-col z-10">
                        <span class="mt-3 text-base font-semibold mx-3">:</span>
                        <span class="mt-3 text-base font-semibold mx-3">:</span>
                        <span class="mt-3 text-base font-semibold mx-3">:</span>
                        <span class="mt-3 text-base font-semibold mx-3">:</span>
                        <span class="mt-3 text-base font-semibold mx-3">:</span>
                    </div>
                    <div class="flex flex-col z-10 relative">
                        <span class="mt-3 text-base font-semibold mx-3">{{ $ruang->nomor_ruang }}</span>
                        <span class="mt-3 text-base font-semibold mx-3">{{ $ruang->nama_ruang }}</span>
                        <span class="mt-3 text-base font-semibold mx-3">{{ $ruang->jml_pc }}</span>
                        <span class="mt-3 text-base font-semibold mx-3">{{ $ruang->kapasitas_orang }}</span>
                        <span class="mt-3 text-base font-semibold mx-3">
                            <ul>
                                @foreach ($ruang->fasilitas as $fasilitas)
                                    @if ($ruang->fasilitas && $fasilitas->nama_fasilitas && $fasilitas->jumlah)
                                        <li> <span>{{ $fasilitas->jumlah }}</span>
                                            <span>{{ $fasilitas->nama_fasilitas }}</span>
                                        </li>
                                    @else
                                        -
                                    @endif
                                @endforeach
                            </ul>
                        </span>

                        <div class="flex gap-2 left-[25rem] top-[3rem] relative ">
                            <a href="{{ route('edit_ruangan', $ruang->id) }}"><button type="submit"
                                    class="text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg inline-flex items-center justify-center w-full sm:w-auto px-2 py-2 text-center text-md shadow-[0_3px_4px_1px_rgba(0,0,0,0.3)]"><i
                                        class='bx bx-edit me-2'></i>Edit
                                </button>
                            </a>
                            {{-- <form action="{{ route('delete_ruangan', $ruang->id) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit"
                                    class="text-white bg-red-500 hover:bg-red-600  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg inline-flex items-center justify-center sm:w-auto px-2 py-2 text-center text-md">
                                    <i class='bx bxs-trash me-2'></i>Hapus
                                </button>
                            </form> --}}

                            <button id="deleteButton" type="button"
                                class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg inline-flex items-center justify-center sm:w-auto px-2 py-2 text-center text-md">
                                <i class='bx bxs-trash me-2'></i>Hapus
                            </button>

                        </div>
                    </div>
                    {{-- <div class="right-0 mx-5 -z-0 flex-col w-[20rem]  absolute">
                        <img class="rounded-[50px]" src="{{ asset('storage/foto_ruangan/' . $ruang->gambar_ruang) }}"
                            alt="">
                    </div> --}}

                    <div class="bg-slate-300 h-[76%] w-1/2 rounded-3xl mx-auto bg-cover bg-center"
                        style="background-image: url({{ asset('storage/foto_ruangan/' . $ruang->gambar_ruang) }})">

                    </div>

                    {{-- <img src="{{ asset('storage/foto_ruangan/' . $ruang->gambar_ruang) }}" class="bg-slate-300 h-[50%] w-1/2 rounded-3xl mx-auto bg-cover" alt="Deskripsi Gambar"> --}}
                </div>
            </div>
        @endforeach
        <br>
        <div id="modal" class="hidden fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-3 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            {{-- <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <!-- Heroicon name: exclamation -->
                            </div> --}}
                            <div class="text-center flex flex-col items-center justify-center">
                                <svg class="h-12 w-12 mb-4 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.01 5H18a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                                    Hapus Ruangan
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Apakah Anda yakin ingin menghapus ruangan ini? Tindakan ini tidak dapat dibatalkan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 flex justify-end items-end">
                        @foreach ($ruanganList as $ruang)
                        <form action="{{ route('delete_ruangan', $ruang->id) }}" method="POST" id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <button id="confirmButton" type="button"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Hapus
                            </button>
                        </form>
                        @endforeach
                        <button id="cancelButton" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
          const modal = document.getElementById('modal');
          const confirmButton = document.getElementById('confirmButton');
          const cancelButton = document.getElementById('cancelButton');
          const deleteForm = document.getElementById('deleteForm');
      
          confirmButton.addEventListener('click', function() {
            modal.classList.add('hidden');
            deleteForm.submit();
          });
      
          cancelButton.addEventListener('click', function() {
            modal.classList.add('hidden');
          });
      
          // Show modal when delete button is clicked
          document.getElementById('deleteButton').addEventListener('click', function() {
            modal.classList.remove('hidden');
          });
        });
      </script>
      

@endsection
