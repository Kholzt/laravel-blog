<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->increments("id")->primary();
            $table->string("slug")->unique();
            $table->string("thumbnail");
            $table->string("keterangan", 100);
            $table->string("judul", 100);
            $table->text("konten");
            $table->bigInteger("id_penulis")->unsigned();
            $table->integer("id_kategori")->unsigned();
            $table->timestamps();

            $table->foreign("id_kategori")->references("id")->on("kategori")->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("id_penulis")->references("id")->on("users")->onUpdate("cascade")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
