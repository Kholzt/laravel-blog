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
        <i class="fa fa-check me-2"></i> {{ session()->get('success') }}
    </div>
    @elseif(session()->has('error'))
    <div class="bg-red-600 px-4 py-2 alert text-white">
        <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session()->get('error') }}
    </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ $data->type == 'add' ? route('berita.store') : route('berita.update', $data->data->id) }}" method="POST" enctype="multipart/form-data" class="p-4">
                    @csrf
                    @if($data->type == 'edit')
                    @method('PUT')
                    <p class="text-white text-end mb-4">Dibuat pada {{$data->data->created_at}}</p>
                    @endif
                    @csrf
                    <div class="grid lg:grid-cols-2 gap-4">
                        <div class="md:col-span-1 col-span-2">
                            <label for="thumbnail" class="text-white mb-2 block">Gambar</label>
                            <label>
                                <input accept="image/*" type="file" name="thumbnail" class="hidden" id="thumbnail">
                                <div class="flex-col border-dashed border-white border h-36 bg-gray-700 rounded-md flex justify-center items-center preview-container">
                                    <img id="thumbnail-preview" src="{{Storage::url($data->data->thumbnail)}}" alt="Pratinjau Gambar" class="rounded-md mb-2 {{$data->data->thumbnail == ''?'hidden':''}} h-full w-auto">
                                    <i class="fa fa-image text-4xl text-white"></i>
                                    <p class="text-sm text-white {{$data->data->thumbnail != ''?'hidden':''}}">Unggah gambar disini</p>
                                </div>
                            </label>
                            @error("thumbnail")
                            <small class="text-red-500">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="md:col-span-1 col-span-2">
                            <div class="mb-4">
                                <label for="judul" class="text-white mb-2 block">Judul Berita</label>
                                <input value="{{ old('judul', $data->data->judul) }}" type="text" name="judul" placeholder="Masukkan Judul Berita" class="slug px-4 py-2 w-full text-white rounded-md bg-gray-700" id="judul">
                                @error("judul")
                                <small class="text-red-500">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="">
                                <label for="slug" class="text-white mb-2 block">Slug</label>
                                <input value="{{ old('slug', $data->data->slug) }}" type="text" name="slug" placeholder="Masukkan Slug Berita" class="slug-target px-4 py-2 w-full text-white rounded-md bg-gray-700" id="slug">
                                @error("slug")
                                <small class="text-red-500">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="">
                            <label for="keterangan" class="text-white mb-2 block">Keterangan</label>
                            <input value="{{ old('keterangan', $data->data->keterangan) }}" type="text" name="keterangan" placeholder="Masukkan Keterangan Berita" class=" px-4 py-2 w-full text-white rounded-md bg-gray-700" id="keterangan">
                            @error("keterangan")
                            <small class="text-red-500">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-span-2">
                            <label for="konten" class=" text-white mb-2 block">Konten Berita</label>
                            <textarea name="konten" id="konten" rows="5xx" placeholder="Masukkan konten berita" class="rich-text px-4 py-2 w-full text-white rounded-md bg-gray-700">{{ old('konten', $data->data->konten) }}</textarea>
                            @error("konten")
                            <small class="text-red-500">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-span-1">
                            <label for="id_kategori" class="text-white mb-2 block">Kategori</label>
                            <select class="px-4 py-2 w-full text-white rounded-md bg-gray-700" name="id_kategori" id="id_kategori">
                                <option value="">Pilih kategori</option>
                                @foreach($data->kategori as $kategori)
                                <option {{$kategori->id == old("id_kategori",$data->data->id_kategori) ?"selected":""}} value="{{$kategori->id}}">{{$kategori->nama}}</option>
                                @endforeach
                            </select>
                            @error("id_kategori")
                            <small class="text-red-500">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-span-1">
                            <label for="tags" class="text-white mb-2 block">Tags</label>
                            <select class="px-4 select2 py-2 w-full text-white rounded-md bg-gray-700" name="tags[]" multiple id="tags">
                                <option value=""></option>
                                @foreach($data->tags as $tag)
                                <option {{in_array($tag->id ,old("tags",$data->data->tags)) ?"selected":""}} value="{{$tag->id}}">{{$tag->nama}}</option>
                                @endforeach
                            </select>
                            @error("tags")
                            <small class="text-red-500">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:me-2 sm:w-auto">Simpan</button>
                        <a href="/dashboard/berita" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-6 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" data-close=".modal">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>


</x-app-layout>
<script>
    $(document).ready(function() {
        $(".select2").select2({
            placeholder: "Pilih tag",
            tags: true
        });
        $('#thumbnail').on('change', function(event) {
            const file = event.target.files[0];
            const $preview = $('#thumbnail-preview');
            const $container = $('.preview-container');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $preview.attr('src', e.target.result).removeClass('hidden');
                    $container.find('i').addClass('hidden');
                    $container.find('p').addClass('hidden');
                }

                reader.readAsDataURL(file);
            } else {
                $preview.attr('src', '').addClass('hidden');
                $container.find('i').removeClass('hidden');
                $container.find('p').removeClass('hidden');
            }
        });
    })
</script>