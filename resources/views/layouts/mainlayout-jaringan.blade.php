<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/main.js', 'resources/css/output3.css'])

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <title>Dashboard | @yield('title')</title>
</head>

<body class="font-poppins h-screen w-screen overflow-x-hidden">

    {{-- Sidebar --}}

    <div id="sidebar"
        class="close z-50 fixed top-0 left-0 h-screen w-72 bg-sidebarunj px-[10px] py-[14px] text-white">
        <header class="relative">
            <div class="flex items-center">
                <span class="image flex items-center ms-1">
                    <img src="{{ asset('img/UNJ__Universitas_Negeri_Jakarta__Logo_-_Download_Free_PNG-removebg-preview (1) 1.svg') }}"
                        alt="">
                </span>

                <div class="text text-[14px] font-semibold flex flex-col whitespace-nowrap">
                    <span class="name">UPT TIK</span>
                    <span class="profession mt-1">Universitas Negeri Jakarta</span>
                </div>
            </div>
            <!-- <div id="toggle" class="absolute top-[50%] -right-[25px] -translate-y-1/2 w-[25px] h-[25px] bg-purple-600 rounded-xl flex items-center justify-center">
                <i class='bx bx-chevron-right'></i>
            </div> -->
            <hr class="my-4">
        </header>

        <div class="mt-5">
            <div class="">
                <p class="text leading-relaxed text-lg flex items-center justify-center mb-2">
                    <span id="ucapan" class="capitalize font-bold text-sm"></span>
                </p>
                <ul class="">
                    <li class="link flex items-center justify-center">
                        <a href="{{ route('home_jaringan') }}"
                            class="hover:bg-putihan/[10%] flex whitespace-nowrap px-5 rounded-lg transition duration-300 ease-in-out
                        {{ Request::route()->named('home_jaringan') ? 'active-link' : '' }}
                        ">
                            <i class='bx bxs-home text-xl mx-1 me-7'></i>
                            <span class="text">Dashboard</span>
                        </a>
                    </li>
                    <li class="link flex items-center justify-center">
                        <a href="{{ route('peminjaman_jaringan') }}"
                            class="hover:bg-putihan/[10%] flex whitespace-nowrap px-5 rounded-lg transition duration-300 ease-in-out
                        {{ Request::route()->named('peminjaman_jaringan') ? 'active-link' : '' }}
                        ">
                            <i class='bx bxs-spreadsheet text-xl mx-1 me-7'></i>
                            <span class="text">Peminjaman</span>
                        </a>
                    </li>
                    <li class="link flex items-center justify-center">
                        <a href="{{ route('referensi_jaringan') }}"
                            class="hover:bg-putihan/[10%] flex whitespace-nowrap px-5 rounded-lg transition duration-300 ease-in-out
                        {{ Request::route()->named('referensi_jaringan') ? 'active-link' : '' }}
                        ">
                            <i class='bx bxs-file-find text-xl mx-1 me-7'></i>
                            <span class="text">Data Referensi</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    {{-- Left Nav End --}}

    {{-- Top Nav Start --}}


    <section class="w-[calc(100%-18rem)] relative left-72 home h-screen transition-all duration-[0.7s] ease-in-out">
        <div class="p-4 rounded-lg h-screen">
            <div class="flex justify-center items-center">
                <div class="w-[90%] h-[62px] border-b-2 border-black">
                    <div class="flex ms-4">
                        <button id="toggle" type="button"
                            class="inline-flex items-center p-2 m-2 text-sm text-black rounded-lg">
                            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                                </path>
                            </svg>
                        </button>
                        <span class="text-2xl font-semibold flex items-center">@yield('page')</span>
                        <div class="flex ms-auto me-4 rounded-full py-2 shadow-all-side h-14 cursor-pointer"
                            data-modal-target="popup-modal" data-modal-toggle="popup-modal">
                            @if (Auth::user()->image)
                                <img class="rounded-full w-10 h-10 ms-5"
                                    src="{{ asset('storage/foto_profile_akun/' . Auth::user()->image) }}"
                                    alt="">
                            @else
                                <img src="{{ asset('./img/default_profile.png') }}" class="rounded-full w-10 h-10 ms-5">
                            @endif
                            <span
                                class="me-5 ms-3 flex items-center font-medium text-lg capitalize">{{ Auth::user()->name }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- top nav end  --}}

            {{-- content start --}}

            @yield('content')

            {{-- content end --}}


            {{-- modal-start --}}
            <div id="popup-modal" tabindex="-1" data-modal-backdrop="static"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-lg max-h-full">
                    <div
                        class="relative bg-white rounded-lg transition-all duration-1000 ease-in-out shadow-all-side p-7">
                        <div class="p-4 md:p-5 text-center">
                            <svg class="mx-auto mb-4 text-red-600 w-20 h-20" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="#FFFFFF" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <h3 class="mb-5 text-xl font-semibold text-slate-800">Apakah anda yakin ingin keluar?</h3>
                            <a href="{{ route('logout') }}" data-modal-hide="popup-modal" type="button"
                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-semibold rounded-lg text-lg inline-flex items-center px-5 py-2.5 text-center">
                                Yes
                            </a>
                            <button data-modal-hide="popup-modal" type="button"
                                class="py-2.5 px-5 ms-3 text-lg font-semibold text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-400 hover:bg-gray-400 hover:text-white focus:z-10 focus:ring-4 focus:ring-gray-100">
                                No
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- modal-end --}}

            <script>
                var time = new Date().getHours();

                // Mendapatkan elemen dengan id "greeting"
                var greetingElement = document.getElementById('ucapan');

                // Mengatur pesan salam berdasarkan waktu
                if (time < 12) {
                    greetingElement.textContent = 'Selamat Pagi, {{ Auth::user()->RelasiRoles->name }} UPT TIK';
                } else if (time < 15) {
                    greetingElement.textContent = 'Selamat Siang, {{ Auth::user()->RelasiRoles->name }} UPT TIK';
                } else if (time < 18) {
                    greetingElement.textContent = 'Selamat Sore, {{ Auth::user()->RelasiRoles->name }} UPT TIK';
                } else {
                    greetingElement.textContent = 'Selamat Malam, {{ Auth::user()->RelasiRoles->name }} UPT TIK';
                }
            </script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
            <script src="main.js"></script>
</body>

</html>
