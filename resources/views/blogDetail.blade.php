<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {!! seo()->for($data->berita) !!}

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
            <div class="relative w-full max-w-2xl px-6 lg:max-w-5xl">
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

                <main class="mt-6 mx-auto">

                    <a href="" class=" rounded  py-1 text-white   px-4 text-lg border border-white">{{$data->berita->kategori->nama}}</a>
                    <h5 class="font-bold text-white " style="font-size:3rem">{{$data->berita->judul}}</h5>
                    <span class="text-white text-sm capitalize">Dibuat {{Helpers::formatTanggal($data->berita->created_at)}}</span>
                    <figure>
                        <img src="{{Storage::url($data->berita->thumbnail)}}" class="rounded-md mt-4 w-full aspect-video" alt="Blog 1">
                    </figure>

                    <caption>
                        <div class="mt-4 text-gray-200 mb-4 max-w-full prose prose-invert">
                            {!! $data->berita->konten !!}
                        </div>
                    </caption>
                    <div class="flex gap-2 mt-10">

                        @foreach($data->berita->tags as $tag)
                        <a href="/tags/{{$tag->slug}}" class=" rounded  py-1 hover:bg-white text-white transition-all hover:text-black border border-white  px-4 text-sm">{{$tag->nama}}</a>
                        @endforeach
                    </div>

                </main>
                <div id="disqus_thread"></div>

                <footer class="py-16 text-center text-sm text-white dark:text-white/70">
                    BLOG META VERSION
                </footer>
            </div>

        </div>
    </div>
    <script>
        /**
         *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
         *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
        /*
        var disqus_config = function () {
        this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
        this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
        };
        */
        var disqus_config = function() {
            this.page.url = PAGE_URL; // Replace PAGE_URL with your page's canonical URL variable
            this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
        };
        (function() { // DON'T EDIT BELOW THIS LINE
            var d = document,
                s = d.createElement('script');
            s.src = 'https://blog-app-12.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
</body>

</html>