@extends('layouts.mainlayout-admin')

@section('title', 'Peminjaman')
@section('page', 'Peminjaman')

@section('content')

    <div class="rounded-lg shadow-all-side w-[80%] h-[90%] my-5 mx-auto">
        <div class="mx-10 pt-3">
            <div class="flex border-b-2 border-black w-full items-center font-semibold mb-3">
                <i class='bx bx-laptop text-2xl mx-4'></i>
                <span class="text-xl">Input Surat Peminjaman</span>
            </div>
        </div>
        @if (session('error'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium text-base">{{ session('error') }}</span>
            </div>
        @endif

        <form class="mx-10 " action="{{ route('surat_store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-2">
                <label for="nomor_surat" class="block mb-2 text-sm text-gray-900 font-semibold">Nomor Surat</label>
                <input type="text" id="nomor_surat" name="nomor_surat"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5 placeholder:text-gray-800"
                    value="" placeholder="***/***-**/***/**/**" required />
            </div>
            <div class="mb-2">
                <label for="asal_surat" class="block mb-2 text-sm text-gray-900 font-semibold">Asal Surat</label>
                <input type="text" id="asal_surat" name="asal_surat"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5"
                    placeholder="Masukkan asal surat" required />
            </div>
            <div class="mb-2">
                <label for="nama_peminjam" class="block mb-2 text-sm text-gray-900 font-semibold">Nama Peminjam</label>
                <input type="text" id="nama_peminjam" name="nama_peminjam"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5"
                    placeholder="Masukkan nama peminjam" required />
            </div>
            <div class="mb-2">
                <label for="mulai_dipinjam" class="block mb-2 text-sm text-gray-900 font-semibold">Tanggal Peminjam</label>
                <input type="date" id="mulai_dipinjam" name="mulai_dipinjam"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5" required />
            </div>
            <div class="mb-2">
                <label for="selesai_dipinjam" class="block mb-2 text-sm text-gray-900 font-semibold">Lama Peminjam</label>
                <input type="date" id="selesai_dipinjam" name="selesai_dipinjam"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5" required />
            </div>
            <div class="mb-2">
                <label for="jml_ruang" class="block mb-2 text-sm text-gray-900 font-semibold">Jumlah Ruang</label>
                <input type="number" id="jml_ruang" name="jml_ruang"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5"placeholder="Masukkan jumlah ruangan yang diinginkan"
                    required />
            </div>
            <div class="mb-2">
                <label for="jml_pc" class="block mb-2 text-sm text-gray-900 font-semibold">Jumlah PC</label>
                <input type="number" id="jml_pc" name="jml_pc"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5"placeholder="Masukkan jumlah komputer yang diinginkan"
                    required />
            </div>
            <div class="flex gap-2 mt-5 items-center">
                <input type="file" id="file" name="file" class="hidden" onchange="displayFileName()">
                <label for="file"
                    class="flex items-center text-base bg-gray-500 hover:bg-gray-600 text-center px-5 py-2 select-none cursor-pointer rounded-2xl text-white">
                    <i class='bx bx-cloud-upload text-2xl'></i>
                    <span class="ms-2">Add File</span>
                </label>
                <span id="file-name"></span>
                <a href="{{ route('peminjaman') }}"
                    class="text-white ms-auto bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-2xl text-sm w-full sm:w-auto px-5 py-2.5 text-center">Cancel</a>
                <button type="submit"
                    class="text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-2xl text-sm w-full sm:w-auto px-5 py-2.5 text-center">Save</button>
            </div>
        </form>
    </div>


    <script>
        function displayFileName() {
            const fileInput = document.getElementById('file');
            const fileName = document.getElementById('file-name');
            if (fileInput.files.length > 0) {
                fileName.textContent = fileInput.files[0].name;
            } else {
                fileName.textContent = '';
            }
        }
    </script>

@endsection
