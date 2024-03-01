@extends('layouts.mainlayout-jaringan')

@section('title', 'Jaringan-dashboard')
@section('page', 'Dashboard')

@section('content')

<div class="w-[936px] h-[90px] shadow-all-side flex mx-auto mt-10 px-5 py-3">
    <svg class="w-10 h-10 text-gray-800 my-1 mx-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
        <path fill-rule="evenodd" d="M2 12a10 10 0 1 1 20 0 10 10 0 0 1-20 0Zm9.4-5.5a1 1 0 1 0 0 2 1 1 0 1 0 0-2ZM10 10a1 1 0 1 0 0 2h1v3h-1a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-1v-4c0-.6-.4-1-1-1h-2Z" clip-rule="evenodd"/>
    </svg>
        <div class="flex flex-col grow tracking-wider my-auto">
            <span class="font-semibold md:lg:text-2xl sm:text-md">Selamat Datang di Sistem Informasi Peminjaman Ruangan</span>
          <span class="font-semibold md:lg:text-lg sm:text-sm">saat ini anda login sebagai Admin Jaringan</span>
        </div>           
    </div>
    
    
    <div class="flex items-center justify-center h-48 gap-4 mt-14 rounded text-white group">
        <div class="w-[425px] h-[225px] bg-red-500 rounded-lg relative hover:scale-105 transition-all duration-500 ease-in-out">
            <div class="flex m-5">
                <div class="w-[65%] h-full my-auto mx-5">
                    <span class="whitespace-nowrap block text-3xl font-semibold align-middle">0</span>
                    <span class="whitespace-nowrap block text-2xl font-semibold align-middle">Peminjaman</span>
                </div>
                <div class="w-full h-full flex justify-center items-center mx-5">
                    <i class='bx bx-list-ul text-[150px]'></i>                            
                </div>
            </div>
            <a href="{{ route('peminjaman_jaringan') }}">
                <div class="bg-red-600 w-full h-8 absolute bottom-0 left-0 flex items-center justify-center rounded-lg cursor-pointer" >
                    <span class="my-auto">Selengkapnya</span>
                    <i class='bx bxs-right-arrow-circle ms-2 text-2xl my-auto'></i>
                </div>
            </a>
        </div>

        <div class="w-[425px] h-[225px] bg-gray-500 rounded-lg relative hover:scale-105 transition-all duration-500 ease-in-out">
            <div class="flex m-5">
                <div class="w-[65%] h-full my-auto mx-5 ms-12">
                    <span class="whitespace-nowrap block text-3xl font-semibold align-middle text-center">Data</span>
                    <span class="whitespace-nowrap block text-2xl font-semibold align-middle text-center">Referensi</span>
                </div>
                <div class="w-full h-full flex justify-center items-center mx-5">
                    <i class='bx bxs-file-find text-[150px]'></i>                            
                </div>
            </div>
            <a href="{{ route('referensi_jaringan') }}">
                <div class="bg-gray-700 w-full h-8 absolute bottom-0 left-0 flex items-center justify-center rounded-lg cursor-pointer" >
                    <span class="my-auto">Selengkapnya</span>
                    <i class='bx bxs-right-arrow-circle ms-2 text-2xl my-auto'></i>
                </div>
            </a>
        </div>
    </div>



@endsection