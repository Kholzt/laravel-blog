<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;

class BlogLandingController extends Controller
{
    public function index()
    {
        $search = request()->search;
        $kategori = request()->kategori;

        $berita = Berita::when($search, function ($qr) use ($search) {
            $qr->where("judul", "like", "%$search%")
                ->orWhereHas("kategori", function ($query) use ($search) {
                    $query->where("nama", "like", "%$search%");
                })
                ->orWhereHas("tags", function ($query) use ($search) {
                    $query->where("nama", "like", "%$search%");
                });
        })
            ->when($kategori, function ($qr) use ($kategori) {
                $qr->whereHas("kategori", function ($query) use ($kategori) {
                    $query->where("slug", $kategori);
                });
            })
            ->orderBy("id", "desc")
            ->get();


        $kategori = Kategori::orderBy("id", "desc")->get();
        $params["data"] = (object) [
            "berita" => $berita,
            "kategori" => $kategori,
        ];
        return view("blog", $params);
    }
    public function blogDetail($slug)
    {
        $berita = Berita::where("slug", $slug)->first();
        if (!$berita) {
            abort(404);
        }

        $params["data"] = (object) [
            "berita" => $berita,
        ];
        return view("blogDetail", $params);
    }

    public function kategori($slug)
    {
        $berita = Berita::whereHas("kategori", function ($query) use ($slug) {
            $query->where("slug", $slug);
        })
            ->orderBy("id", "desc")
            ->get();

        $params["data"] = (object) [
            "type" => "Kategori",
            "key" => str_replace("-", " ", $slug),
            "berita" => $berita,
        ];
        return view("kategori-tag", $params);
    }
    public function tag($slug)
    {
        $berita = Berita::whereHas("tags", function ($query) use ($slug) {
            $query->where("slug", $slug);
        })
            ->orderBy("id", "desc")
            ->get();

        $params["data"] = (object) [
            "type" => "Tag",
            "key" => str_replace("-", " ", $slug),
            "berita" => $berita,
        ];
        return view("kategori-tag", $params);
    }
}
