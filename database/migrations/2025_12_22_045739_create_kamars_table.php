<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kamars', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kamar', 50);
            $table->enum('tipe', ['biasa', 'reguler', 'vip']);
            $table->integer('harga');
            $table->text('deskripsi')->nullable();
            $table->json('fasilitas')->nullable(); // Store fasilitas as JSON array
            $table->text('preview_360')->nullable(); // URL untuk embed 3D Vista
            $table->enum('status', ['tersedia', 'penuh'])->default('tersedia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kamars');
    }
};
