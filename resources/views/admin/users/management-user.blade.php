@extends('layouts.mainlayout-admin')

@section('title', 'Management-user')
@section('page', 'Management-user')

@section('content')


    @if (session()->has('success'))
        <div id="alert-border-3"
            class="fixed top-2 right-0 z-50 m-14 w-1/3 flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800"
            role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <div class="ms-3 text-lg font-medium">
                {{ session()->get('success') }}
            </div>
            <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                data-dismiss-target="#alert-border-3" aria-label="Close">
                <span class="sr-only">Dismiss</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    @endif


    <div class="flex flex-col mx-[6.25rem] mt-10">

        <div class="border-b border-black inline-flex justify-between items-center p-3 text-xl font-medium cursor-default">
            <span>Manajemen user</span>
            <a href="{{ route('management-users-create') }}">
                <button data-modal-target="default-modal" data-modal-toggle="default-modal" type="button"
                    class="px-5 py-2.5 text-base font-medium text-center inline-flex items-center text-white bg-blue-500 rounded-full hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    <i class='bx bx-plus text-xl me-1'></i>
                    Tambah Data
                </button>
            </a>
        </div>

        <div class="flex my-2 gap-2 p-3">
            <span>Show</span>
            <div class="">
                <form id="filterForm" action="{{ route('management-users') }}" method="GET" class="mx-auto">
                    <label for="numero"></label>
                    <select name="numero" id="numero"
                        class="outline-none py-1 px-2 text-center border border-gray-300 shadow-[0_0px_5px_1px_rgba(0,0,0,0.2)]">
                        @if ($numero)
                            <option value="{{ $numero }}">{{ $numero }}</option>
                        @else
                            <option value="10">10</option>
                        @endif
                        @for ($i = 1; $i <= 10; $i++)
                            @if ($numero != $i)
                                <option value={{ $i }}>{{ $i }}</option>
                            @endif
                        @endfor
                    </select>
                </form>
            </div>
            <span>entries</span>
        </div>

        <script>
            document.getElementById("numero").addEventListener("change", function() {
                document.getElementById("filterForm").submit();
            });
        </script>



        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="odd:bg-white">
                                <th scope="col"
                                    class="px-6 py-3 whitespace-nowrap text-start text-xs font-medium uppercase">No</th>
                                <th scope="col"
                                    class="px-6 py-3 whitespace-nowrap text-start text-xs font-medium uppercase">Nama</th>
                                <th scope="col"
                                    class="px-6 py-3 whitespace-nowrap text-start text-xs font-medium uppercase">Email</th>
                                <th scope="col"
                                    class="px-6 py-3 whitespace-nowrap text-start text-xs font-medium uppercase">Role</th>
                                <th scope="col"
                                    class="px-6 py-3 whitespace-nowrap text-start text-xs font-medium uppercase">Status</th>
                                <th scope="col"
                                    class="px-6 py-3 whitespace-nowrap text-start text-xs font-medium uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="">

                            @foreach ($Users as $item)
                                <tr class="odd:bg-gray-200">
                                    <td class="px-6 py-2 whitespace-nowrap text-sm text-start">
                                        {{ $loop->iteration + $Users->firstItem() - 1 }}</td>
                                    <td class="px-6 py-2 whitespace-nowrap text-sm text-start">{{ $item->name }}</td>
                                    <td class="px-6 py-2 whitespace-nowrap text-sm text-start">{{ $item->email }}</td>
                                    <td class="px-6 py-2 whitespace-nowrap text-sm text-start capitalize">
                                        {{ $item->RelasiRoles->name }}</td>
                                    <td class="px-6 py-2 whitespace-nowrap text-sm text-start">
                                        @if ($item->active == 1)
                                            <span
                                                class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded">Aktif</span>
                                        @else
                                            <span
                                                class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-2 whitespace-nowrap text-sm">
                                        <a href="{{ route('management-users-edit', $item->id) }}">
                                            <button type="button"
                                                class="text-white bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium inline-flex items-center justify-center rounded-lg text-sm px-3 py-2 text-center">
                                                <i class='bx bx-edit text-lg text-center me-1'></i>
                                                Edit
                                            </button>
                                        </a>
                                        <button data-modal-target="popup-modal-{{ $item->id }}"
                                            data-modal-toggle="popup-modal-{{ $item->id }}"
                                            type="button"class="text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium inline-flex items-center justify-center rounded-lg text-sm px-3 py-2 text-center">
                                            <i class='bx bx-trash text-lg text-center me-1'></i>
                                            Hapus
                                        </button>
                                        @if ($item->active)
                                            <form action="{{ route('nonaktif.user', $item->id) }}" method="POST">
                                                @csrf
                                                <button class="text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium inline-flex items-center justify-center rounded-lg text-sm px-3 py-2 text-center">Non-Aktif</button>
                                            </form>
                                        @else
                                            <form action="{{ route('aktif.user', $item->id) }}" method="POST">
                                                @csrf
                                                <button  class="text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium inline-flex items-center justify-center rounded-lg text-sm px-3 py-2 text-center">
                                                    Aktif
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                    <div class="my-5">
                        {{ $Users->appends(['numero' => $numero])->links('pagination::tailwind') }}

                    </div>

                    {{-- modal --}}
                    @foreach ($Users as $item)
                        <div id="popup-modal-{{ $item->id }}" tabindex="-1"
                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <div class="relative bg-white rounded-lg shadow">
                                    <button type="button"
                                        class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                        data-modal-hide="popup-modal-{{ $item->id }}">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <div class="p-4 md:p-5 text-center">
                                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        <h3 class="text-lg font-normal text-gray-500">Apakah anda ingin menghapus user
                                            dengan name :
                                            {{ $item->name }}?</h3>
                                        <p class="text-gray-500 mb-5 text-sm">Data yang terhapus tidak dapat dikembalikan
                                        </p>

                                        <form action="{{ route('management-user-destroy', ['id' => $item->id]) }}"
                                            method="POST"
                                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                            @csrf
                                            @method('DELETE')
                                            <button data-modal-hide="popup-modal-{{ $item->id }}" type="submit">
                                                Ya, saya setuju.
                                            </button>
                                        </form>
                                        <button data-modal-hide="popup-modal-{{ $item->id }}" type="button"
                                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Tidak</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

@endsection
