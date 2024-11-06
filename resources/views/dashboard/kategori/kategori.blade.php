<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __($data->title) }}
            </h2>
            <a href="/dashboard/kategori/create" class="px-4 py-2 bg-blue-500 text-white rounded-md ">Tambah Kategori</a>
        </div>
    </x-slot>
    @if(session()->has('success'))
    <div class="bg-green-600 px-4 py-2 alert text-white">
        <i class="fa fa-check me-2"></i> {{session()->get('success')}}
    </div>
    @elseif(session()->has('error'))
    <div class="bg-red-600 px-4 py-2 alert text-white">
        <i class="fa-solid fa-circle-exclamation me-2"></i> {{session()->get('error')}}
    </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden text-white p-4 shadow-sm sm:rounded-lg">
                <table class="text-white table-auto w-full ">
                    <thead>
                        <tr>
                            <th align="left" class="px-4 py-2 w-14 border-b border-slate-500">No</th>
                            <th align="left" class="px-4 py-2 border-b border-slate-500">Nama</th>
                            <th class="w-44 border-b border-slate-500"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data->data as $kategori)
                        <tr>
                            <td class="px-4 py-2 border-b border-slate-500">{{$loop->iteration}}</td>
                            <td class="px-4 py-2 border-b border-slate-500">{{$kategori->nama}}</td>
                            <td class="px-4 py-2 border-b border-slate-500">
                                <a href="/dashboard/kategori/{{$kategori->id}}/edit" class="text-yellow-500 hover:text-yellow-500/70 text-sm"><i class="fa-solid fa-pencil me-1"></i> Ubah</a>
                                <button data-toggle=".modal" data-id="{{$kategori->id}}" data-nama="{{$kategori->nama}}" class="ms-2 deleteBtn text-red-500 hover:text-red-500/70 text-sm"><i class="fa fa-trash me-1"></i> Hapus</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        <div class="relative z-10 invisible modal transition-all opacity-0 ease-out " aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <form action="" method="post">
                @csrf
                @method("delete")
                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <div class="">
                                    <div class="mt-3 text-center  sm:mt-0 sm:text-left">
                                        <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Hapus Kategori</h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500 ">Apakah anda yakin menghapus kategori <span class="kategori-name font-bold"></span>? Kategori akan dihapus secara permanent dan tidak dapat di kembalikan</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex  sm:px-6">
                                <button type="submit" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:me-3 sm:w-auto">Hapus</button>
                                <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" data-close=".modal">Batal</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
</x-app-layout>
