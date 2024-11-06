<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __($data->title) }}
            </h2>
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
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if($data->type=="add")
                <form action="/dashboard/kategori" method="post" class="p-4">
                    @else
                    <form action="/dashboard/kategori/{{$data->data->id}}" method="post" class="p-4">
                        @method("put")
                        @endif
                        @csrf
                        <div class="grid lg:grid-cols-2 gap-4">
                            <div class="">
                                <label for="nama" class="text-white mb-2 block">Nama</label>
                                <input value="{{old('nama',$data->data->nama)}}" type="text" name="nama" placeholder="Nama Kategori" class="px-4 slug py-2 w-full text-white rounded-md bg-gray-700" id="nama">
                                @error("nama")
                                <small class="text-red-500">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="">
                                <label for="slug" class="text-white mb-2 block">Slug</label>
                                <input value="{{old('slug',$data->data->slug)}}" type="text" name="slug" placeholder="Slug Kategori" class="px-4 slug-target py-2 w-full text-white rounded-md bg-gray-700" id="slug">
                                @error("slug")
                                <small class="text-red-500">{{$message}}</small>
                                @enderror
                            </div>

                        </div>
                        <div class="mt-6">
                            <button type="submit" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:me-2 sm:w-auto">Simpan</button>
                            <a href="/dashboard/tag" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-6 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" data-close=".modal">Batal</a>
                        </div>
                    </form>
            </div>
        </div>

</x-app-layout>

<script>
    $(document).ready(function() {
        // let table = new DataTable('table');
        $("[data-toggle]").on("click", function() {
            $($(this).attr("data-toggle")).removeClass("invisible")
            $($(this).attr("data-toggle")).removeClass("opacity-0")
            $($(this).attr("data-toggle")).addClass("opacity-1")
        })
        $("[data-close]").on("click", function() {
            $($(this).attr("data-close")).addClass("invisible")
            $($(this).attr("data-close")).addClass("opacity-0")
            $($(this).attr("data-close")).removeClass("opacity-1")
        })
    })
</script>