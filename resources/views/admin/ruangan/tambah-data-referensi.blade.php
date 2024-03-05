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
                    <label class="block text-sm font-semibold mb-1">Pilih Fasilitas:</label>
                    <div id="facilities">
                        <div class="inline-flex items-center">
                            <div class="w-1/2">
                                <select name="fasilitas[nama_fasilitas][]" class="form-select py-1 px-2">
                                    <option value="AC">AC</option>
                                    <option value="Keyboard">Keyboard</option>
                                    <option value="Mouse">Mouse</option>
                                    <!-- Add more options for other facilities -->
                                </select>
                            </div>
                            <div class="w-1/2">
                                <input type="number" name="fasilitas[jumlah][]" class="form-input py-1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- <div class="mb-2">
                <label for="fasilitas" class="block mb-2 text-sm text-gray-900 font-semibold">Fasilitas</label>
                <input type="text" id="fasilitas"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5" />
            </div> --}}



            <div class="flex gap-2 mt-3">
                <input type="file" id="uploadfile" class="hidden">
                <label for="uploadfile"
                    class="flex items-center text-base bg-gray-500 hover:bg-gray-600 text-center px-5 py-2 select-none cursor-pointer rounded-2xl text-white">
                    <i class='bx bx-cloud-upload text-2xl'></i>
                    <span class="ms-2">Add Picture</span>
                </label>
                <a class="ms-auto" href="{{ route('data-referensi') }}"><button type="button"
                        class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-2xl text-sm w-full sm:w-auto px-5 py-2.5 text-center">Cancel</button></a>
                <button type="submit"
                    class="text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-2xl text-sm w-full sm:w-auto px-5 py-2.5 text-center">Save</button>
                <button type="button" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    id="add-facility">Tambah Fasilitas</button>
            </div>
        </form>
    </div>


    <script>
        document.getElementById("add-facility").addEventListener("click", function() {
            var container = document.getElementById("facilities");

            var div = document.createElement("div");
            div.classList.add("flex", "items-center", "mb-2");

            var select = document.createElement("select");
            select.setAttribute("name", "fasilitas[nama_fasilitas][]");
            select.classList.add("form-select", "w-1/2");
            select.innerHTML = `
            <option value="AC">AC</option>
            <option value="Keyboard">Keyboard</option>
            <option value="Mouse">Mouse</option>
            <!-- Add more options for other facilities -->
        `;

            var inputJumlah = document.createElement("input");
            inputJumlah.setAttribute("type", "number");
            inputJumlah.setAttribute("name", "fasilitas[jumlah][]");
            inputJumlah.classList.add("form-input", "w-1/2");

            var removeButton = document.createElement("button");
            removeButton.classList.add("bg-red-500", "hover:bg-red-700", "text-white", "font-bold", "py-1", "px-2",
                "rounded", "ml-2");
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
@endsection
