@extends('layouts.mainlayout-ka')

@section('title', 'Detail Surat')

@section('content')

    <div class="w-[90%] h-[90%] mx-auto flex justify-center pt-3 relative ">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-putihan rounded-lg shadow-all-side">
                <div class="flex items-center p-4 border-b border-gray-700 rounded-t">
                    <a href="{{ route('peminjaman_kepala_upt') }}"><button type="button"
                            class="text-gray-600 bg-transparent hover:bg-gray-300 hover:text-gray-900 rounded-lg text-sm w-8 h-8 me-2 inline-flex justify-center items-center transition-all duration-200 ease-in-out">
                            <i class='bx bx-arrow-back text-xl'></i>
                            <span class="sr-only">Close modal</span>
                        </button></a>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Surat Pengajuan
                    </h3>
                </div>
                <div class="p-4 md:p-5 space-y-4">
                    <div class="flex">
                        <div class="flex flex-col z-10">
                            <span class="block mt-3 mx-3 text-base font-semibold">Nomor Surat</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">Asal Surat</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">Nama Peminjam</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">Tanggal Mulai Dipinjam</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">Lama Peminjaman</span>
                        </div>
                        <div class="flex flex-col z-10">
                            <span class="block mt-3 mx-3 text-base font-semibold">:</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">:</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">:</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">:</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">:</span>
                        </div>
                        <div class="flex flex-col z-10">
                            <span class="block mt-3 mx-3 text-base font-semibold">{{ $pengajuanList->nomor_surat }}</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">{{ $pengajuanList->asal_surat }}</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">{{ $pengajuanList->nama_peminjam }}</span>
                            <span class="block mt-3 mx-3 text-base font-semibold">
                                @php
                                    try {
                                        $tanggal = \Carbon\Carbon::parse($pengajuanList->mulai_dipinjam);
                                        echo $tanggal->format('d F Y', 'Asia/Jakarta');
                                    } catch (\Exception $e) {
                                        echo 'Invalid Date';
                                    }
                                @endphp
                            </span>
                            @php
                            try {
                                $mulai = \Carbon\Carbon::parse($pengajuanList->mulai_dipinjam);
                                $selesai = \Carbon\Carbon::parse($pengajuanList->selesai_dipinjam);

                                // Menghitung selisih waktu dalam hitungan hari
                                $selisihHari = $selesai->diffInDays($mulai);

                                // Menambahkan jumlah hari peminjaman ke selisih hari
                                $hariPeminjaman = $selisihHari + 1; // ditambah 1 karena hari mulai juga dihitung

                                echo "<span class='block mt-3 mx-3 text-base font-semibold'> $hariPeminjaman hari </span>";
                            } catch (\Exception $e) {
                                echo 'Invalid Date';
                            }
                        @endphp
                        </div>
                    </div>
                </div>
                <div class="flex ps-8 p-4 rounded-b">
                    <a href="{{ asset('storage/file_surat/' . $pengajuanList->file_surat) }}" target="_blank"
                        class="bg-gray-300 hover:bg-gray-400 focus:ring-4 focus:outline-none focus:ri   ng-blue-300 font-medium rounded-md text-sm px-5 py-2.5 text-center transition-all duration-200 ease-in-out">Surat
                        Pengajuan</a>
                    <div class="flex ms-auto">
                        <form
                            action="{{ route('respond_kepala_upt', ['id' => $pengajuanList->id, 'response' => 'reject']) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-700 text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-7 py-2.5 ms-auto text-center transition-all duration-200 ease-in-out">Tolak</button>
                        </form>

                        <form
                            action="{{ route('respond_kepala_upt', ['id' => $pengajuanList->id, 'response' => 'accept']) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-700 text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-5 py-2.5 ms-1.5 text-center transition-all duration-200 ease-in-out">Terima</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="hidden absolute w-full z-50 h-24  mt-20 -top-[-20rem] right-0 px-4">
                <div class="bg-putihan rounded-lg w-full shadow-all-side py-2 px-4 flex flex-col">
                    <div class="border-b border-gray-400 w-[146px] cursor-default">
                        <span class="text-base font-medium whitespace-nowrap">Alasan Penolakan</span>
                    </div>


                    <div class="flex">
                        <input id="message" rows="1"
                            class="block mt-1.5 p-2.5 w-[85%] text-sm text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:border-blue-500 focus:outline-none placeholder:text-gray-600"
                            placeholder="Alasan..."></input>
                        <button type="submit"
                            class="inline-flex w-[15%] bg-gray-300 hover:bg-gray-400 text-gray-600 rounded-xl ms-1.5 mt-1.5 items-center justify-center border focus:border-blue-500">Kirim</button>
                    </div>

                </div>
            </div>


        </div>


    @endsection
