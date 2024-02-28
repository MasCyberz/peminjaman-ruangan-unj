@extends('layouts.mainlayout-ka')

@section('title', 'Home')

@section('content')

    <div class="p-4 sm:ml-64 h-screen">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 h-screen ">
            <div class="grid sm:grid-cols-1 2xl:grid-cols-2 gap-10">
                <div class="flex flex-col p-5 justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
                    <h1 class="text-2xl">0</h1>
                    <p class="text-2xl text-slate-600 dark:text-gray-500">Peminjaman</p>
                </div>
            </div>
        </div>
    </div>

@endsection
