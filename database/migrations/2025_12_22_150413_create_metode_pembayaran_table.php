<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('metode_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50); // Transfer Bank, QRIS, Tunai
            $table->string('kode', 20)->unique(); // transfer, qris, cash
            $table->text('deskripsi')->nullable();
            $table->string('nomor_rekening', 50)->nullable(); // untuk transfer
            $table->string('nama_rekening', 100)->nullable(); // untuk transfer
            $table->string('nama_bank', 50)->nullable(); // BCA, Mandiri, dll
            $table->string('qr_code')->nullable(); // path gambar QR
            $table->boolean('aktif')->default(true);
            $table->integer('urutan')->default(0); // untuk sorting
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('metode_pembayaran');
    }
};
