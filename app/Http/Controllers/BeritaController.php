<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Exception;
use Helpers;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Berita::orderBy("id", "desc")->get();
        $params["data"] = (object)[
            "title" => "Berita",
            "data" => $data
        ];
        return view("dashboard.berita.berita", $params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::all();
        $tag = Tag::all();
        $params["data"] = (object)[
            "title" => "Tambah Berita",
            "type" => "add",
            "kategori" => $kategori,
            "tags" => $tag,
            "data" => (object)[
                "id" => "",
                "thumbnail" => "",
                "slug" => "",
                "judul" => "",
                "keterangan" => "",
                "konten" => "",
                "id_kategori" => "",
                "tags" => [],
                "created_at" => ""
            ]
        ];
        return view("dashboard.berita.form", $params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'slug' => 'required|unique:berita,slug|max:100',
                'judul' => 'required|max:100',
                'keterangan' => 'required|max:100',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'konten' => 'required',
                'id_kategori' => 'required|exists:kategori,id',
                'tags' => 'required|array'
            ], [
                'slug.required' => 'Slug wajib diisi.',
                'slug.unique' => 'Slug sudah digunakan, silakan gunakan slug yang berbeda.',
                'slug.max' => 'Slug tidak boleh lebih dari 100 karakter.',
                'judul.required' => 'Judul wajib diisi.',
                'keterangan.required' => 'Keterangan wajib diisi.',
                'judul.max' => 'Judul tidak boleh lebih dari 100 karakter.',
                'thumbnail.required' => 'Thumbnail wajib diisi.',
                'thumbnail.image' => 'File harus berupa gambar.',
                'thumbnail.mimes' => 'Thumbnail harus berupa file dengan format jpeg, png, jpg, atau gif.',
                'thumbnail.max' => 'Ukuran thumbnail maksimal 2MB.',
                'konten.required' => 'Konten wajib diisi.',
                'id_kategori.required' => 'Kategori wajib diisi.',
                'id_kategori.exists' => 'Kategori yang dipilih tidak valid.',
                'tags.required' => 'Tag wajib diisi.',
                'tags.array' => 'Tag harus berupa array.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput($request->all());
            }

            // Handle file upload
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            // Create Berita
            $berita = Berita::create([
                'slug' => $request->slug,
                'judul' => $request->judul,
                'keterangan' => $request->keterangan,
                'thumbnail' => $thumbnailPath,
                'konten' => $request->konten,
                'id_kategori' => $request->id_kategori,
                "id_penulis" => auth()->user()->id
            ]);

            // Handle tags
            $tags = $request->tags;
            $tagIds = [];
            foreach ($tags as $id) {
                // Cek apakah tag sudah ada berdasarkan ID
                $tag = Tag::find($id);

                if (!$tag) {
                    // Jika tidak ada, buat tag baru dengan nama dan slug dari input
                    $tagName = $id;
                    $tag = Tag::create([
                        'nama' => $tagName,
                        'slug' => \Str::slug($tagName)
                    ]);
                }

                $tagIds[] = $tag->id;
            }

            $berita->tags()->sync($tagIds);

            return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan.');
        } catch (Exception $e) {

            return redirect()->back()->with('error', 'Terjadi kesalahan pada server. Silakan coba lagi.')->withInput($request->all());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $berita = Berita::findOrFail($id);
            $kategori = Kategori::all();
            $tag = Tag::all();
            $params["data"] = (object)[
                "title" => "Ubah Berita",
                "type" => "edit",
                "kategori" => $kategori,
                "tags" => $tag,
                "data" => (object)[
                    "id" => $berita->id,
                    "thumbnail" => $berita->thumbnail,
                    "slug" => $berita->slug,
                    "judul" => $berita->judul,
                    "keterangan" => $berita->keterangan,
                    "konten" => $berita->konten,
                    "id_kategori" => $berita->id_kategori,
                    "tags" => $berita->tags->pluck('id')->toArray(),
                    "created_at" => Helpers::formatTanggal($berita->created_at)
                ]
            ];

            return view("dashboard.berita.form", $params);
        } catch (Exception $e) {
            return redirect()->route('berita.index')->with('error', 'Berita tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $berita = Berita::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'slug' => 'required|unique:berita,slug,' . $berita->id . '|max:100',
                'judul' => 'required|max:100',
                'keterangan' => 'required|max:100',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'konten' => 'required',
                'id_kategori' => 'required|exists:kategori,id',
                'tags' => 'required|array'
            ], [
                'slug.required' => 'Slug wajib diisi.',
                'slug.unique' => 'Slug sudah digunakan, silakan gunakan slug yang berbeda.',
                'slug.max' => 'Slug tidak boleh lebih dari 100 karakter.',
                'judul.required' => 'Judul wajib diisi.',
                'keterangan.required' => 'Keterangan wajib diisi.',
                'judul.max' => 'Judul tidak boleh lebih dari 100 karakter.',
                'thumbnail.image' => 'File harus berupa gambar.',
                'thumbnail.mimes' => 'Thumbnail harus berupa file dengan format jpeg, png, jpg, atau gif.',
                'thumbnail.max' => 'Ukuran thumbnail maksimal 2MB.',
                'konten.required' => 'Konten wajib diisi.',
                'id_kategori.required' => 'Kategori wajib diisi.',
                'id_kategori.exists' => 'Kategori yang dipilih tidak valid.',
                'tags.required' => 'Tag wajib diisi.',
                'tags.array' => 'Tag harus berupa array.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Handle file upload if thumbnail is provided
            if ($request->hasFile('thumbnail')) {
                // Delete the old thumbnail
                Storage::disk('public')->delete($berita->thumbnail);
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                $berita->thumbnail = $thumbnailPath;
            }

            $berita->update([
                'slug' => $request->slug,
                'judul' => $request->judul,
                'keterangan' => $request->keterangan,
                'konten' => $request->konten,
                'id_kategori' => $request->id_kategori,
            ]);

            // Handle tags
            $tags = $request->tags;
            $tagIds = [];
            foreach ($tags as $id) {
                // Cek apakah tag sudah ada berdasarkan ID
                $tag = Tag::find($id);

                if (!$tag) {
                    // Jika tidak ada, buat tag baru dengan nama dan slug dari input
                    $tagName = $id;
                    $tag = Tag::create([
                        'nama' => $tagName,
                        'slug' => \Str::slug($tagName)
                    ]);
                }

                $tagIds[] = $tag->id;
            }

            $berita->tags()->sync($tagIds);

            return redirect()->route('berita.index')->with('success', 'Berita berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $berita = Berita::findOrFail($id);

            // Delete the thumbnail if it exists
            Storage::disk('public')->delete($berita->thumbnail);

            $berita->delete();

            return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server. Silakan coba lagi.');
        }
    }
}
