<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = "kategori";
    protected $fillable = ["nama", "slug"];

    public function berita()
    {
        return $this->hasMany(Berita::class, "id_kategori", "id");
    }
}
