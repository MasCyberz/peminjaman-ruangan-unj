@extends('layouts.mainlayout-admin')

@section('title', 'Home')
@section('page', 'Dashboard')

@section('content')

    {{-- welkam --}}

    <div class="w-[936px] h-[90px] shadow-all-side flex mx-auto mt-10 px-5 py-3">
        <svg class="w-10 h-10 text-gray-800 my-1 mx-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
            viewBox="0 0 24 24">
            <path fill-rule="evenodd"
                d="M2 12a10 10 0 1 1 20 0 10 10 0 0 1-20 0Zm9.4-5.5a1 1 0 1 0 0 2 1 1 0 1 0 0-2ZM10 10a1 1 0 1 0 0 2h1v3h-1a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-1v-4c0-.6-.4-1-1-1h-2Z"
                clip-rule="evenodd" />
        </svg>
        <div class="flex flex-col grow tracking-wider my-auto">
            <p class="font-semibold md:lg:text-2xl sm:text-md">Selamat Datang di Sistem Informasi Peminjaman
                Ruangan</p>
            <p class="font-semibold md:lg:text-lg sm:text-sm">saat ini anda login sebagai Admin UPT TIK</p>
        </div>
    </div>

    

    <!-- Content Start -->
    <div class="flex items-center justify-center h-48 gap-4 mt-14 rounded text-white">
        <div
            class="w-[425px] h-[225px] bg-red-500 rounded-lg relative hover:scale-105 transition-all duration-500 ease-in-out">
            <div class="flex m-5">
                <div class="w-[65%] h-full my-auto mx-5">
                    <span class="whitespace-nowrap block text-3xl font-semibold align-middle">0</span>
                    <p class="whitespace-nowrap block text-2xl font-semibold align-middle">Peminjaman</p>
                </div>
                <div class="w-full h-full flex justify-center items-center mx-5">
                    <i class='bx bx-list-ul text-[150px]'></i>
                </div>
            </div>
            <div
                class="bg-red-600 w-full h-8 absolute bottom-0 left-0 flex items-center justify-center rounded-lg cursor-pointer">
                <p class="my-auto">Selengkapnya</p>
                <i class='bx bxs-right-arrow-circle ms-2 text-2xl my-auto'></i>
            </div>
        </div>

        <div
            class="w-[425px] h-[225px] bg-blue-500 rounded-lg relative hover:scale-105 transition-all duration-500 ease-in-out">
            <div class="flex m-5">
                <div class="w-[65%] h-full my-auto mx-5">
                    <span class="whitespace-nowrap block text-3xl font-semibold align-middle">0</span>
                    <span class="whitespace-nowrap block text-2xl font-semibold align-middle">Peminjaman</span>
                </div>
                <div class="w-full h-full flex justify-center items-center mx-5">
                    <i class='bx bxs-user text-[150px]'></i>
                </div>
            </div>
            <div
                class="bg-blue-600 w-full h-8 absolute bottom-0 left-0 flex items-center justify-center rounded-lg cursor-pointer">
                <p class="my-auto">Selengkapnya</p>
                <i class='bx bxs-right-arrow-circle ms-2 text-2xl my-auto'></i>
            </div>
        </div>
    </div>
    </div>
    <!-- Content End -->

    <!-- modal keluar akun-->
    <div id="popup-modal" tabindex="-1" data-modal-backdrop="static"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <div class="relative bg-white rounded-lg transition-all duration-1000 ease-in-out shadow-all-side p-7">
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-red-600 w-20 h-20" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="#FFFFFF" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-xl font-semibold text-slate-800">Apakah anda yakin ingin keluar?</h3>
                    <a href="login.html">
                        <button data-modal-hide="popup-modal" type="button"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-semibold rounded-lg text-lg inline-flex items-center px-5 py-2.5 text-center">
                            Yes
                        </button>
                    </a>
                    <button data-modal-hide="popup-modal" type="button"
                        class="py-2.5 px-5 ms-3 text-lg font-semibold text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-400 hover:bg-gray-400 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                        No
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection
