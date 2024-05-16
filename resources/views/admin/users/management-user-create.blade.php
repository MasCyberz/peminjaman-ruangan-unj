@extends('layouts.mainlayout-admin')

@section('title', 'Peminjaman')
@section('page', 'Peminjaman')

@section('content')

    <div class="rounded-lg shadow-all-side w-[80%] my-5 p-8 mx-auto">
        <form class="mx-10" action="{{ route('management-users-store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex border-b-2 border-black w-full font-semibold mb-3">
                <i class='bx bx-laptop text-2xl mx-4'></i>
                <span class="text-base">Form Pendaftaran</span>
            </div>
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 my-3 rounded relative" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="mb-2">
                <label for="nama" class="block mb-2 text-sm text-gray-900 font-semibold">Nama</label>
                <input type="text" id="nama" name="name" value="{{ old('name') }}"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5" />
                @error('name')
                    <p class="text-red-500 text-sm italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-2">
                <label for="password" class="block mb-2 text-sm text-gray-900 font-semibold">Password</label>
                <input type="password" id="password" name="password"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5" />
                @error('password')
                    <p class="text-red-500 text-sm italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-2">
                <label for="email" class="block mb-2 text-sm text-gray-900 font-semibold">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5" />
                @error('email')
                    <p class="text-red-500 text-sm italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-2 ">
                <label for="role" class="block mb-2 text-sm text-gray-900 font-semibold">Role</label>
                <select name="role_id" id="role"
                    class=" border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5">
                    @foreach ($roles as $item)
                        <option value="{{ $item->id }}" class="rounded-none py-2 px-2">{{ $item->name }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')
                    <p class="text-red-500 text-sm italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex gap-2 mt-3">
                <input type="file" id="foto_profil" name="foto_profil" class="hidden" onchange="displayFileName()">
                <label for="foto_profil"
                    class="flex items-center text-base bg-gray-500 hover:bg-gray-600 text-center px-5 py-2 select-none cursor-pointer rounded-2xl text-white">
                    <i class='bx bx-cloud-upload text-2xl'></i>
                    <span class="ms-2">Add Picture</span>
                </label>
                <span id="file-name" class="w-[40%]"></span>
                <a class="ms-auto" href="{{ route('management-users') }}"><button type="button"
                        class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-2xl text-sm w-full sm:w-auto px-5 py-2.5 text-center">Cancel</button></a>
                <button type="submit"
                    class="text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-2xl text-sm w-full sm:w-auto px-5 py-2.5 text-center">Save</button>
            </div>
            <span class="text-xs text-red-500">*Jika tidak ada foto abaikan.</span>
        </form>
    </div>

    <script>
        function displayFileName() {
            const fileInput = document.getElementById('foto_profil');
            const fileName = document.getElementById('file-name');
            if (fileInput.files.length > 0) {
                fileName.textContent = fileInput.files[0].name;
            } else {
                fileName.textContent = '';
            }
        }
    </script>

@endsection
