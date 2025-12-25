<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('persetujuan_peraturan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('reservasi_id')->nullable()->constrained('reservasis')->cascadeOnDelete();
            $table->string('versi_peraturan', 50);
            $table->timestamp('disetujui_pada');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persetujuan_peraturan');
    }
};
