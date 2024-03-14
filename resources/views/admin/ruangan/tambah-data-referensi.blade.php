@extends('layouts.mainlayout-admin')
@section('title', 'Tambah Data Referensi')
@section('page', 'Tambah Data Referensi')


@section('content')
    <div class="rounded-lg shadow-all-side w-[80%] my-5 p-8 mx-auto">

        <form class="mx-10" action="{{ route('ruangan_store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex border-b-2 border-black w-full font-semibold mb-3">
                <i class='bx bx-laptop text-2xl mx-4'></i>
                <span class="text-base">Form Input Ruangan</span>
            </div>
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 my-3 rounded relative" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Periksa kembali!</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-2">
                <label for="nomor_ruang" class="block mb-2 text-sm text-gray-900 font-semibold">Nomor Ruangan</label>
                <input type="number" id="nomor_ruang" name="nomor_ruang"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5" />
            </div>
            <div class="mb-2">
                <label for="nama_ruang" class="block mb-2 text-sm text-gray-900 font-semibold">Nama Ruangan</label>
                <input type="text" id="nama_ruang" name="nama_ruang"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5" />
            </div>
            <div class="mb-2">
                <label for="jml_pc" class="block mb-2 text-sm text-gray-900 font-semibold">Jumlah PC</label>
                <input type="number" id="jml_pc" name="jml_pc"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5" />
            </div>
            <div class="mb-2">
                <label for="kapasitas_orang" class="block mb-2 text-sm text-gray-900 font-semibold">Kapasitas Orang</label>
                <input type="number" id="kapasitas_orang" name="kapasitas_orang"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5" />
            </div>


            <div id="facilities-container">
                <div class="mb-4">
                    <label class="block text-sm text-gray-900 font-semibold mb-1.5">Pilih Fasilitas:</label>
                    <div id="facilities">
                        <div class="inline-flex items-center gap-2 mb-3">
                            <div class=" h-10 inline-flex items-center justify-center">
                                <select name="fasilitas[nama_fasilitas][]" class="focus:outline-none py-1 px-2 text-start">
                                    <option value="PC">PC</option>
                                    <option value="Monitor">Monitor</option>
                                    <option value="Keyboard">Keyboard</option>
                                    <option value="Mouse">Mouse</option>
                                    <option value="Headset">Headset</option>
                                    <option value="AC">AC</option>
                                    <option value="Papan Tulis">Papan Tulis</option>
                                    <option value="Lampu">Lampu</option>
                                    <option value="Speaker">Speaker</option>
                                    <option value="Screen Proyektor">Screen Proyektor</option>
                                    <option value="CCTV">CCTV</option>
                                    <option value="Meja">Meja</option>
                                    <option value="Kursi">Kursi</option>
                                    <option value="Stopkontak">Stopkontak</option>
                                    <option value="Jam Dinding">Jam Dinding</option>
                                    <option value="Webcam">Webcam</option>
                                </select>
                            </div>
                            <div class=" h-10 inline-flex items-center justify-center">
                                <input type="number" name="fasilitas[jumlah][]" class="focus:outline-none py-1">
                            </div>
                            <button type="button"
                                class=" bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-3 rounded-lg"
                                id="add-facility">Tambah Fasilitas</button>
                        </div>
                    </div>

                </div>

            </div>


            {{-- <div class="mb-2">
                <label for="fasilitas" class="block mb-2 text-sm text-gray-900 font-semibold">Fasilitas</label>
                <input type="text" id="fasilitas"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5" />
            </div> --}}



            <div class="flex gap-2 mt-3 items-center">
                <input id="foto" type="file" name="foto" class="hidden" onchange="displayFileName()" multiple>
                <label for="foto"
                    class="flex items-center text-base bg-gray-500 hover:bg-gray-600 text-center px-5 py-2 select-none cursor-pointer rounded-2xl text-white shadow-[0_4px_4px_1px_rgba(0,0,0,0.3)]">
                    <i class='bx bx-cloud-upload text-2xl'></i>
                    <span class="ms-2">Add Picture</span>
                </label>
                <span id="file-name"></span>
                <a class="ms-auto text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-2xl text-sm sm:w-auto px-5 py-2.5 text-center shadow-[0_4px_4px_1px_rgba(0,0,0,0.3)]"
                    href="{{ route('data-referensi') }}">Cancel</a>
                <button type="submit"
                    class="text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-2xl text-sm w-full sm:w-auto px-5 py-2.5 text-center shadow-[0_4px_4px_1px_rgba(0,0,0,0.3)]">Save</button>
            </div>
        </form>
    </div>


    <script>
        document.getElementById("add-facility").addEventListener("click", function() {
            var container = document.getElementById("facilities");

            var div = document.createElement("div");
            div.classList.add("flex", "items-center", "mb-2", "gap-2");

            var select = document.createElement("select");
            select.setAttribute("name", "fasilitas[nama_fasilitas][]");
            select.classList.add("h-10", "py-1", "px-2", "focus:outline-none");
            select.innerHTML = `
        <option value="AC">AC</option>
        <option value="Keyboard">Keyboard</option>
        <option value="Mouse">Mouse</option>
        <option value="Headset">Headset</option>
        <option value="Monitor">Monitor</option>
        <option value="PC">PC</option>
        <option value="Papan Tulis">Papan Tulis</option>
        <option value="Lampu">Lampu</option>
        <option value="Speaker">Speaker</option>
        <option value="Screen Proyektor">Screen Proyektor</option>
        <option value="CCTV">CCTV</option>
        <option value="Meja">Meja</option>
        <option value="Kursi">Kursi</option>
        <option value="Stopkontak">Stopkontak</option>
        <option value="Jam Dinding">Jam Dinding</option>
        <option value="Webcam">Webcam</option>
        <!-- Add more options for other facilities -->
    `;

            var inputJumlah = document.createElement("input");
            inputJumlah.setAttribute("type", "number");
            inputJumlah.setAttribute("name", "fasilitas[jumlah][]");
            inputJumlah.classList.add("h-10", "focus:outline-none");

            var removeButton = document.createElement("button");
            removeButton.classList.add("bg-red-500", "hover:bg-red-700", "text-white", "font-bold", "py-2", "px-2",
                "rounded", "ml-2", "transition-all", "duration-300", "ease-in-out");
            removeButton.textContent = "Hapus";
            removeButton.addEventListener("click", function() {
                div.remove();
            });

            div.appendChild(select);
            div.appendChild(inputJumlah);
            div.appendChild(removeButton);

            container.appendChild(div);
        });
    </script>

    <script>
        function displayFileName() {
            const fileInput = document.getElementById('foto');
            const fileName = document.getElementById('file-name');
            if (fileInput.files.length > 0) {
                fileName.textContent = fileInput.files[0].name;
            } else {
                fileName.textContent = '';
            }
        }
    </script>
@endsection
