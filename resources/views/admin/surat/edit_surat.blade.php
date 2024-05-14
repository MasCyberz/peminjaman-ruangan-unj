@extends('layouts.mainlayout-admin')

@section('title', 'Edit surat')
@section('page', 'Edit Surat')

@section('content')

    <div class="rounded-lg shadow-all-side w-[80%] h-auto pb-4 my-5 mx-auto">
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

        <form class="mx-10 " action="{{ route('update_surat', ['id' => $SuratYgDiedit->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf

            @method('PUT')
            <div class="mb-2">
                <label for="nomor_surat" class="block mb-2 text-sm text-gray-900 font-semibold">Nomor Surat</label>
                <input type="text" id="nomor_surat" name="nomor_surat" value="{{ $SuratYgDiedit->nomor_surat }}"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5 placeholder:text-gray-800"
                    value="" placeholder="***/***-**/***/**/**" />
                @error('nomor_surat')
                    <p class="text-red-500 text-sm mt-1 capitalize">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-2">
                <label for="asal_surat" class="block mb-2 text-sm text-gray-900 font-semibold">Asal Surat</label>
                <input type="text" id="asal_surat" name="asal_surat" value="{{ $SuratYgDiedit->asal_surat }}"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5 "
                    placeholder="Masukkan asal surat" />
                @error('asal_surat')
                    <p class="text-red-500 text-sm mt-1 capitalize">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-2">
                <label for="nama_peminjam" class="block mb-2 text-sm text-gray-900 font-semibold">Nama Peminjam</label>
                <input type="text" id="nama_peminjam" name="nama_peminjam" value="{{ $SuratYgDiedit->nama_peminjam }}"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5"
                    placeholder="Masukkan nama peminjam" />
                @error('nama_peminjam')
                    <p class="text-red-500 text-sm mt-1 capitalize">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-2">
                <label for="jml_hari" class="block mb-2 text-sm text-gray-900 font-semibold">Jumlah Hari</label>
                <input type="number" id="jml_hari" name="jml_hari" value="{{ $SuratYgDiedit->jml_hari }}"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5"placeholder="Masukkan jumlah ruangan yang diinginkan"
                    readonly />
                @error('jml_hari')
                    <p class="text-red-500 text-sm mt-1 capitalize">{{ $message }}</p>
                @enderror
            </div>

            <div id="peminjamanFields">
                @foreach ($SuratYgDiedit->detailPeminjaman as $index => $detailPeminjaman)
                    <div class="peminjaman" id="peminjaman_{{ $index }}">
                        <div>
                            <label for="tanggal_{{ $index }}" class="block">Tanggal Peminjaman</label>
                            <input type="date" id="tanggal_{{ $index }}" name="tanggal_peminjaman[]"
                                class="mt-1 p-2 border border-gray-300 rounded-md" min="{{ date('Y-m-d') }}"
                                value="{{ $detailPeminjaman->tanggal_peminjaman }}">
                            <button type="button" class="mt-2 p-2 bg-red-500 text-white rounded-md"
                                onclick="hapusPeminjaman('{{ $index }}')">
                                Hapus
                            </button>
                        </div>
                        @error('tanggal_peminjaman')
                            <p class="text-red-500 text-sm mt-1 capitalize">{{ $message }}</p>
                        @enderror

                        <div>
                            <label for="jml_ruang_{{ $index }}" class="block">Jumlah Ruangan</label>
                            <input type="number" id="jml_ruang_{{ $index }}" name="jml_ruang[]"
                                class="mt-1 p-2 border border-gray-300 rounded-md"
                                value="{{ $detailPeminjaman->jml_ruang }}">
                        </div>
                        @error('jml_ruang')
                            <p class="text-red-500 text-sm mt-1 capitalize">{{ $message }}</p>
                        @enderror
                        <div>
                            <label for="jml_pc_{{ $index }}" class="block">Jumlah PC</label>
                            <input type="number" id="jml_pc_{{ $index }}" name="jml_pc[]"
                                class="mt-1 p-2 border border-gray-300 rounded-md" value="{{ $detailPeminjaman->jml_pc }}">
                        </div>
                        @error('jml_pc')
                            <p class="text-red-500 text-sm mt-1 capitalize">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                <button type="button" id="tambahPeminjaman"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Tambah
                    Peminjaman</button>
            </div>

            <div class="flex gap-2 mt-5 items-center">
                <input type="file" id="file" name="file" class="hidden" value="{{ $SuratYgDiedit->file_surat }}"
                    onchange="displayFileName()">
                <label for="file"
                    class="flex items-center text-base bg-gray-500 hover:bg-gray-600 text-center px-5 py-2 select-none cursor-pointer rounded-2xl text-white">
                    <i class='bx bx-cloud-upload text-2xl'></i>
                    <span class="ms-2">Add File</span>
                </label>
                @error('file')
                    <p class="text-red-500 text-sm mt-1 capitalize">{{ $message }}</p>
                @enderror
                <span id="file-name"></span>
                <a href="{{ route('peminjaman') }}"
                    class="text-white ms-auto bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-2xl text-sm w-full sm:w-auto px-5 py-2.5 text-center">Cancel</a>
                <button type="submit"
                    class="text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-2xl text-sm w-full sm:w-auto px-5 py-2.5 text-center">Save</button>
            </div>
        </form>
    </div>
    <br>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tambahPeminjamanBtn = document.getElementById('tambahPeminjaman');
            const peminjamanFieldsContainer = document.getElementById('peminjamanFields');
            const jumlahHariInput = document.getElementById('jml_hari'); // Ambil elemen input jml_hari

            let peminjamanIndex = {{ $SuratYgDiedit->detailPeminjaman->count() }};

            tambahPeminjamanBtn.addEventListener('click', function() {
                const peminjamanField = document.createElement('div');
                peminjamanField.classList.add('peminjaman');

                peminjamanField.innerHTML = `
                    <div>
                        <label for="tanggal_${peminjamanIndex}" class="block">Tanggal Peminjaman</label>
                        <input type="date" id="tanggal_${peminjamanIndex}" name="tanggal_peminjaman[]" class="mt-1 p-2 border border-gray-300 rounded-md" min="{{ date('Y-m-d') }}">
                        <button type="button" class="hapus-peminjaman mt-2 p-2 bg-red-500 text-white rounded-md">Hapus</button>
                    </div>
                    <div>
                        <label for="jml_ruang_${peminjamanIndex}" class="block">Jumlah Ruangan</label>
                        <input type="number" id="jml_ruang_${peminjamanIndex}" name="jml_ruang[]" class="mt-1 p-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="jml_pc_${peminjamanIndex}" class="block">Jumlah PC</label>
                        <input type="number" id="jml_pc_${peminjamanIndex}" name="jml_pc[]" class="mt-1 p-2 border border-gray-300 rounded-md">
                    </div>
                `;

                const hapusPeminjamanBtn = peminjamanField.querySelector('.hapus-peminjaman');
                hapusPeminjamanBtn.addEventListener('click', function() {
                    peminjamanField.remove();
                    updateJumlahHari(); // Update jumlah hari setelah menghapus peminjaman
                });
                peminjamanFieldsContainer.appendChild(peminjamanField);

                peminjamanIndex++;
                updateJumlahHari(); // Panggil fungsi untuk mengupdate jumlah hari saat menambah peminjaman
            });

            // Fungsi untuk menghitung jumlah hari
            function updateJumlahHari() {
                const inputsTanggal = document.querySelectorAll('input[type="date"]');
                let jumlahHari = 0;
                inputsTanggal.forEach(input => {
                    if (input.value !== '') {
                        jumlahHari++;
                    }
                });

                // Update nilai input jml_hari
                const jumlahHariInput = document.getElementById('jml_hari');
                jumlahHariInput.value = jumlahHari;
            }

            // Panggil fungsi untuk menghitung jumlah hari saat halaman dimuat
            updateJumlahHari();

            // Panggil fungsi updateJumlahHari saat ada perubahan pada input tanggal
            peminjamanFieldsContainer.addEventListener('change', function(event) {
                if (event.target && event.target.matches('input[type="date"]')) {
                    updateJumlahHari();
                }
            });

        });
    </script>

    <script>
        function hapusPeminjaman(index) {
            // Dapatkan div peminjaman berdasarkan id
            var peminjamanDiv = document.getElementById('peminjaman_' + index);
            // Hapus div peminjaman dari parent form
            peminjamanDiv.remove();
            updateJumlahHari(); // Panggil fungsi untuk mengupdate jumlah hari setelah menghapus peminjaman
        }

        // Fungsi untuk menghitung jumlah hari
        function updateJumlahHari() {
            const inputsTanggal = document.querySelectorAll('input[type="date"]');
            let jumlahHari = 0;
            inputsTanggal.forEach(input => {
                if (input.value !== '') {
                    jumlahHari++;
                }
            });

            // Update nilai input jml_hari
            const jumlahHariInput = document.getElementById('jml_hari');
            jumlahHariInput.value = jumlahHari;
        }
    </script>


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
