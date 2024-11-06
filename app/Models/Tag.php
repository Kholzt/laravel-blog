<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = "tag";
    protected $fillable = ["nama", "slug"];

    public function berita()
    {
        return $this->hasMany(Berita_tag::class, "id_tag", "id");
    }
}
