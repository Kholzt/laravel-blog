<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita_tag extends Model
{
    protected $table = "berita_tag";
    protected $fillable = ["judul", "konten", "slug", "id_penulis", "id_kategori"];

    public function tag()
    {
        return $this->belongsTo(Tag::class, "id_tag", "id");
    }
    public function berita()
    {
        return $this->belongsTo(Berita::class, "id_berita", "id");
    }
}
