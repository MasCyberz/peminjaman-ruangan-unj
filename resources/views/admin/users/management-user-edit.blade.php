@extends('layouts.mainlayout-admin')

@section('title', 'Peminjaman')
@section('page', 'Peminjaman')

@section('content')

<div class="rounded-lg shadow-all-side w-[80%] my-5 p-8 mx-auto">
    <form class="mx-10" action="{{ route('management-users-update', ['id' => $User->id]) }}" method="POST">
      @csrf
      @method('PUT')
        <div class="flex border-b-2 border-black w-full font-semibold mb-3">
            <i class='bx bx-laptop text-2xl mx-4'></i>
            <span class="text-base">Form Pendaftaran</span>
        </div>
        
        <div class="mb-2">
          <label for="nama" class="block mb-2 text-sm text-gray-900 font-semibold">Nama</label>
          <input type="text" id="nama" name="name" value="{{ $User->name }}" class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5"/>
        </div>
        <div class="mb-2">
          <label for="password" class="block mb-2 text-sm text-gray-900 font-semibold">Password</label>
          <input type="password" id="password" value="" name="password" class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5"/>
        </div>
        <div class="mb-2">
          <label for="email" class="block mb-2 text-sm text-gray-900 font-semibold">Email</label>
          <input type="email" id="email" name="email" value="{{ $User->email }}" class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5"/>
        </div>
        <div class="mb-2 ">
          <label for="role" class="block mb-2 text-sm text-gray-900 font-semibold">Role</label>
          <select name="role_id" id="role" class="border-none bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-full outline-none ps-5 block w-full p-1.5">
            <option value="{{ $User->role_id }}" class="rounded-none py-2 px-2">{{ $User->RelasiRoles->name }}</option>
            {{-- @foreach ($User as $item)
            <option value=""></option>
            @endforeach --}}
          </select>
        </div>
        <div class="flex gap-2 mt-3">
            <input type="file" id="uploadfile" class="hidden">
                <label for="uploadfile" class="flex items-center text-base bg-gray-500 hover:bg-gray-600 text-center px-5 py-2 select-none cursor-pointer rounded-2xl text-white">
                    <i class='bx bx-cloud-upload text-2xl'></i>
                    <span class="ms-2">Add Picture</span>
                </label>
            <a class="ms-auto" href="{{ route('management-users') }}"><button type="button" class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-2xl text-sm w-full sm:w-auto px-5 py-2.5 text-center">Cancel</button></a>    
            <button type="submit" class="text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-2xl text-sm w-full sm:w-auto px-5 py-2.5 text-center">Save</button>    
        </div>
    </form>
</div>

@endsection