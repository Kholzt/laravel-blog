<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Berita Terbaru</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>


<body class="font-sans antialiased bg-gray-900">
    <div class="">
        <img id="background" class="absolute -left-20 top-0 max-w-[877px]" src="https://laravel.com/assets/img/welcome/background.svg" alt="Laravel background" />
        <div class="relative min-h-screen flex flex-col items-center justify-start selection:bg-[#FF2D20] selection:text-black">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="flex  items-center justify-end gap-2 py-10">

                    @if (Route::has('login'))
                    <nav class="-mx-3 flex flex-1 justify-end">
                        @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Dashboard
                        </a>
                        @else
                        <a
                            href="{{ route('login') }}"
                            class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Log in
                        </a>

                        @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Register
                        </a>
                        @endif
                        @endauth
                    </nav>
                    @endif
                </header>

                <main class="mt-6 ">
                    <div class="mb-10 w-full flex flex-col items-center">
                        <form action="" method="get" class="w-full flex flex-col items-center">
                            <input
                                type="text"
                                class="px-4 py-2 w-[60%] mb-4 rounded-md mx-auto"
                                placeholder="Cari berdasarkan judul, kategori, tag"
                                name="search"
                                value="{{ request('search') }}">
                        </form>
                        <div class="flex gap-2">
                            <a
                                href="?search={{ request('search') }}"
                                class="text-white hover:text-gray-400 text-sm rounded-sm px-3 py-1">
                                Semua
                            </a>
                            @foreach($data->kategori as $kategori)
                            <a
                                href="?search={{ request('search') }}&kategori={{ $kategori->slug }}"
                                class="text-white hover:text-gray-400 text-sm rounded-sm px-3 py-1">
                                {{ $kategori->nama }}
                            </a>
                            @endforeach
                        </div>
                    </div>


                    <div class="grid gap-6 lg:grid-cols-3 lg:gap-8">
                        @foreach($data->berita as $berita)
                        <article class=" shadow-gray-100 bg-white rounded-md overflow-hidden">
                            <a href="/berita/{{$berita->slug}}">
                                <figure>
                                    <img src="{{Storage::url($berita->thumbnail)}}" class="w-full aspect-video" alt="{{$berita->judul}}">
                                </figure>
                            </a>
                            <caption>
                                <div class="p-4">
                                    <a href="/berita/{{$berita->slug}}">
                                        <h5 class="font-bold text-gray-800 text-lg">{{$berita->judul}}</h5>
                                    </a>

                                    <a href="/kategori/{{$berita->kategori->slug}}" class="bg-blue-50 rounded px-2 text-blue-500 border-blue-500 border">{{$berita->kategori->nama}}</a>
                                    <p class=" line-clamp-2 text-gray-500 mb-4 mt-2 ">{{ $berita->keterangan }}</p>
                                    <span class="text-gray-500 text-sm capitalize">{{Helpers::formatTanggal($berita->created_at)}}</span>
                                </div>
                            </caption>
                        </article>
                        @endforeach


                    </div>
                </main>

                <footer class="py-16 text-center text-sm text-white dark:text-white/70">
                    BLOG META VERSION
                </footer>
            </div>
        </div>
    </div>
</body>

</html>