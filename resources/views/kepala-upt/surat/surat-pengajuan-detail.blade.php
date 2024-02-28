@extends('layouts.mainlayout-ka')

@section('title', 'Detail Surat')

@section('content')

    <div class="p-4 sm:ml-64">
        <div class="relative p-4  border-dashed rounded-lg dark:border-gray-700">
            <div class=" grid grid-cols-1 gap-4 mb-4">
                <div class="flex flex-col h-24 dark:bg-gray-800">
                    <p class="text-2xl m-5 text-slate-700 font-semibold dark:text-gray-500">
                        Surat Pengajuan
                    </p>
                    <hr class="border-2 border-black w-full">
                </div>
            </div>
            <div class=" flex flex-col justify-center items-center h-48  mb-10 dark:bg-gray-800">
                <div class="relative p-8 mt-72 w-[65%] bg-white shadow-xl rounded">
                    <div class="flex justify-between items-center">
                        <h1 class="text-2xl font-bold">
                            Surat Pengajuan
                        </h1>

                        <a href="{{ route('peminjaman_kepala_upt') }}"
                            class="p-2 bg-blue-500 rounded-lg text-white ">Kembali</a>
                    </div>
                    <hr class="border-2 mt-3 border-slate-500 w-full">

                    <table class="mt-5 w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="font-medium text-slate-800">
                            <tr>
                                <td class="w-[25%]">Nomor Surat</td>
                                <td>:</td>
                                <td>{{ $pengajuanList->nomor_surat }}</td>
                            </tr>
                            <tr>
                                <td>Asal Surat</td>
                                <td>:</td>
                                <td>{{ $pengajuanList->asal_surat }}</td>
                            </tr>
                            <tr>
                                <td>Nama Peminjam</td>
                                <td>:</td>
                                <td>{{ $pengajuanList->nama_peminjam }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Peminjaman</td>
                                <td>:</td>
                                <td>{{ $pengajuanList->mulai_dipinjam }}</td>
                            </tr>
                            <tr>
                                <td>Akhir Peminjaman</td>
                                <td>:</td>
                                <td>{{ $pengajuanList->selesai_dipinjam }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="flex justify-between items-center mt-5">
                        <a href="{{ asset('storage/file_surat/' . $pengajuanList->file_surat) }}"
                            class=" p-5 bg-blue-400 rounded-xl text-white" target="_blank">Lihat Surat</a>
                    </div>

                    <div class="flex justify-center mt-5">
                        <form
                            action="{{ route('respond_kepala_upt', ['id' => $pengajuanList->id, 'response' => 'reject']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button class="bg-red-500 p-3 text-white rounded-md">Tolak</button>
                        </form>

                        <form
                            action="{{ route('respond_kepala_upt', ['id' => $pengajuanList->id, 'response' => 'accept']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button class="bg-green-500 p-3 text-white rounded-md mx-2">Terima</button>
                        </form>
                    </div>
                </div>
                {{-- <div class="hidden w-1/2 relative top-5 p-5 bg-white shadow-lg" id="alasanPenolakan">
                    <h1 class="mb-5 text-xl font-bold">Alasan Penolakan</h1>
                    <form action="">
                        <label for="">Alasan : </label>
                        <input type="text" name="" id="">

                        <button class="bg-gray-400 py-2 px-5 text-white rounded-md">Kirim</button>
                    </form>
                </div> --}}
            </div>
        </div>
    </div>

    <script>
        document.getElementById('btnTolak').addEventListener('click', function() {
            document.getElementById('alasanPenolakan').classList.toggle('hidden');
        });
    </script>


@endsection
