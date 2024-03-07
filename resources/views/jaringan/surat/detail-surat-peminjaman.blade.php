@extends('layouts.mainlayout-jaringan')

@section('title', 'Jaringan-Peminjaman')
@section('page', 'Peminjaman')

@section('content')

<div class="w-[90%] h-[90%] mx-auto flex justify-center pt-3 relative ">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-putihan rounded-lg shadow-all-side">
            <div class="flex items-center p-4 border-b border-gray-700 rounded-t">
                <a href="{{ route('peminjaman_jaringan') }}"><button type="button" class="text-gray-600 bg-transparent hover:bg-gray-300 hover:text-gray-900 rounded-lg text-sm w-8 h-8 me-2 inline-flex justify-center items-center transition-all duration-200 ease-in-out">
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
                      <span class="block mt-3 mx-3 text-base font-semibold">Tanggal Peminjam</span>
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
                      <span class="block mt-3 mx-3 text-base font-semibold">{{ $suratList->nomor_surat }}</span>
                      <span class="block mt-3 mx-3 text-base font-semibold">{{ $suratList->asal_surat }}</span>
                      <span class="block mt-3 mx-3 text-base font-semibold">{{ $suratList->nama_peminjam }}</span>
                      <span class="block mt-3 mx-3 text-base font-semibold">
                        @php
                        try {
                            $tanggal = \Carbon\Carbon::parse($suratList->mulai_dipinjam);
                            echo $tanggal->format('d F Y', 'Asia/Jakarta');
                        } catch (\Exception $e) {
                            echo 'Invalid Date';
                        }
                    @endphp

                      </span>
                      <span class="block mt-3 mx-3 text-base font-semibold">
                        @php
                            try {
                                $mulai = \Carbon\Carbon::parse($suratList->mulai_dipinjam);
                                $selesai = \Carbon\Carbon::parse($suratList->selesai_dipinjam);

                                // Menghitung selisih waktu dalam hitungan hari
                                $selisihHari = $selesai->diffInDays($mulai);

                                // Menambahkan jumlah hari peminjaman ke selisih hari
                                $hariPeminjaman = $selisihHari + 1; // ditambah 1 karena hari mulai juga dihitung

                                echo  $hariPeminjaman . ' hari';
                            } catch (\Exception $e) {
                                echo 'Invalid Date';
                            }
                        @endphp
                      </span>
                  </div>
                </div>
            </div>
            <div class="flex items-center ps-8 p-4 rounded-b">
                <button data-modal-hide="static-modal" type="button" class="bg-gray-300 hover:bg-gray-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-5 py-2.5 text-center transition-all duration-200 ease-in-out">Surat Pengajuan</button>
            </div>
        </div>
    </div>

    {{-- <div id="reason" aria-hidden="true" class="hidden absolute w-[60%] z-50 h-24 items-center mt-20 bottom-1.5 px-4 mx-w-2xl">
        <div class="bg-putihan rounded-lg w-full shadow-all-side py-2 px-4 flex flex-col transition-all duration-1000 ease-in-out">
            <div class="border-b border-gray-400 w-[146px] cursor-default">
                <span class="text-base font-medium whitespace-nowrap">Alasan Penolakan</span>
            </div>
            

            <div class="flex">
                <textarea id="message" rows="1" class="block mt-1.5 p-2.5 w-[85%] text-sm text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 focus:outline-none placeholder:text-gray-600" placeholder="Alasan..."></textarea>
                <button type="submit" class="inline-flex w-[15%] bg-gray-300 hover:bg-gray-400 text-gray-600 rounded-xl ms-1.5 mt-1.5 items-center justify-center">Kirim</button>
            </div>

        </div>
    </div> --}}
</div>

@endsection