<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Praise&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/main.js', 'resources/css/output3.css'])
</head>

<body>
    <section>
        <div class="bg-cover bg-no-repeat h-screen z-[9]" style="background-image: url(./img/loginbg.png);">
            <div class="container mx-auto flex h-full flex-1 items-center justify-center">
                <div class="w-[450px] max-w-lg drop-shadow-3xl">
                    <div class="leading-loose">
                        <form action="" method="POST"
                            class=" rounded-chonk bg-white bg-opacity-80 backdrop-filter backdrop-blur-sm p-10 border-white/67">
                            @csrf
                            <img src="{{ asset('img/logocropped.png') }}" alt="" class="mt-0 mx-auto">
                            <p class="text-center text-3xl  font-unj text-ijounj mt-0">Mencerdaskan dan<br>
                                Memartabatkan Bangsa
                            </p>

                            @if (session('loginError'))
                                <div class="bg-red-100 bg-opacity-40 border mt-2 border-red-400 text-red-700 px-4 py-3 rounded relative"
                                    role="alert">
                                    <strong class="font-bold">Oops!</strong>
                                    <span class="block sm:inline">{{ session('loginError') }}</span>
                                </div>
                            @endif

                            <div class="relative mt-9">
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-2 border-black appearance-none focus:outline-none focus:ring-0 peer"
                                    placeholder=" " />
                                <label for="email"
                                    class="ps-5 absolute text-sm text-black font-medium duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-transparent px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-100 peer-focus:-translate-y-8 peer-focus:font-medium peer-focus:text-lg">Email</label>
                            </div>

                            <div class="relative mt-9">
                                <input type="password" id="password" name="password"
                                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-2 border-black appearance-none focus:outline-none focus:ring-0 peer"
                                    placeholder=" " />
                                <label for="password"
                                    class="ps-5 absolute text-sm text-black font-medium duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-transparent px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-100 peer-focus:-translate-y-8 peer-focus:font-medium peer-focus:text-lg">Password</label>
                            </div>


                            <div class="mt-9 flex items-center justify-end">
                                <button type="submit"
                                    class="rounded-full bg-buttonunj px-7 py-1 font-medium
                                tracking-wide text-white transition-all duration-300
                                hover:bg-white hover:text-buttonunj">Login</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
