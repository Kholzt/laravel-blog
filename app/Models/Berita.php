<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use RalphJSmit\Laravel\SEO\Models\SEO;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Berita extends Model
{
    use HasSEO;

    protected $table = "berita";
    protected $fillable = ["judul", "keterangan","konten", "slug", "id_penulis", "id_kategori", "thumbnail"];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, "id_kategori", "id");
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'berita_tag', 'id_berita', 'id_tag');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'id_penulis', 'id');
    }

    public function getDynamicSEOData(): SEOData
    {
        // Truncate konten for a short description
        $shortDescription = substr(strip_tags($this->konten), 0, 160) . '...';

        // Generate image path (assuming thumbnail is stored relative to the public path)
        $imagePath = $this->thumbnail ? Storage::url($this->thumbnail) : config('seo.image.fallback');

        // Generate keywords from tags
        $keywords = $this->tags->pluck('nama')->toArray();
        // Set site name from config
        $siteName = config('seo.site_name', 'Default Site Name');

        // Fallback author if the author is not available
        $author = $this->author ? $this->author->name : config('seo.author.fallback', 'Admin');
        return new SEOData(
            title: $this->judul,
            description: $shortDescription,
            author: $author,
            image: $imagePath,
            // tags: $keywords,
            site_name: $siteName,
            robots: config('seo.robots.default'),
            schema: SchemaCollection::make()->addArticle(),

        );
    }
}
