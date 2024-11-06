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
        Schema::create('berita_tag', function (Blueprint $table) {
            $table->integer("id_berita")->unsigned();
            $table->integer("id_tag")->unsigned();

            $table->foreign("id_tag")->references("id")->on("tag")->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("id_berita")->references("id")->on("berita")->onUpdate("cascade")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_tags');
    }
};
