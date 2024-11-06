<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = Tag::orderBy("id", "desc")->get();
        $params["data"] = (object)[
            "title" => "Tag",
            "data" => $data
        ];
        return view("dashboard.tag.tag", $params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $params["data"] = (object)[
            "title" => "Tambah Tag",
            "type" => "add",
            "data" => (object)[
                "id" => "",
                "slug" => "",
                "nama" => "",
            ]
        ];
        return view("dashboard.tag.form", $params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'slug' => 'required|unique:tag,slug|max:50',
                'nama' => 'required|max:100',
            ], [
                'slug.required' => 'Slug wajib diisi.',
                'slug.unique' => 'Slug sudah digunakan.',
                'slug.max' => 'Slug maksimal 50 karakter.',
                'nama.required' => 'Nama wajib diisi.',
                'nama.max' => 'Nama maksimal 100 karakter.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            Tag::create([
                'slug' => $request->slug,
                'nama' => $request->nama,
            ]);

            return redirect()->route('tag.index')->with('success', 'Tag berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server. Silakan coba lagi.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $tag = Tag::findOrFail($id);
            $params["data"] = (object)[
                "title" => "Edit Tag",
                "type" => "edit",
                "data" => (object)[
                    "id" => $tag->id,
                    "slug" => $tag->slug,
                    "nama" => $tag->nama,
                ]
            ];
            return view("dashboard.tag.form", $params);
        } catch (Exception $e) {
            return redirect()->route('tag.index')->with('error', 'Tag tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $tag = Tag::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'slug' => 'required|unique:tag,slug,' . $tag->id . '|max:50',
                'nama' => 'required|max:100',
            ], [
                'slug.required' => 'Slug wajib diisi.',
                'slug.unique' => 'Slug sudah digunakan.',
                'slug.max' => 'Slug maksimal 50 karakter.',
                'nama.required' => 'Nama wajib diisi.',
                'nama.max' => 'Nama maksimal 100 karakter.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $tag->update([
                'slug' => $request->slug,
                'nama' => $request->nama,
            ]);

            return redirect()->route('tag.index')->with('success', 'Tag berhasil diperbarui.');
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
            $tag = Tag::findOrFail($id);
            $tag->delete();

            return redirect()->route('tag.index')->with('success', 'Tag berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server. Silakan coba lagi.');
        }
    }
}
