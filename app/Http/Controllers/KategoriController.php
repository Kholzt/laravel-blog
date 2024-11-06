<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Kategori::orderBy("id", "desc")->get();
        $params["data"] = (object)[
            "title" => "Kategori",
            "data" => $data
        ];
        return view("dashboard.kategori.kategori", $params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $params["data"] = (object)[
            "title" => "Tambah Kategori",
            "type" => "add",
            "data" => (object)[
                "id" => "",
                "slug" => "",
                "nama" => "",
            ]
        ];
        return view("dashboard.kategori.form", $params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'slug' => 'required|unique:kategori,slug|max:50',
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

            Kategori::create([
                'slug' => $request->slug,
                'nama' => $request->nama,
            ]);

            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
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
            $kategori = Kategori::findOrFail($id);
            $params["data"] = (object)[
                "title" => "Edit Kategori",
                "type" => "edit",
                "data" => (object)[
                    "id" => $kategori->id,
                    "slug" => $kategori->slug,
                    "nama" => $kategori->nama,
                ]
            ];
            return view("dashboard.kategori.form", $params);
        } catch (Exception $e) {
            return redirect()->route('kategori.index')->with('error', 'Kategori tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $kategori = Kategori::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'slug' => 'required|unique:kategori,slug,' . $kategori->id . '|max:50',
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

            $kategori->update([
                'slug' => $request->slug,
                'nama' => $request->nama,
            ]);

            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
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
            $kategori = Kategori::findOrFail($id);
            $kategori->delete();

            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server. Silakan coba lagi.');
        }
    }
}
