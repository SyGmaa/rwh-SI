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
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_id')->constrained('jadwal_keberangkatan')->onDelete('restrict');
            $table->string('nama_pendaftar', 255);
            $table->string('no_tlp', 20)->nullable();
            $table->bigInteger('dp')->default(0);
            $table->enum('metode_bayar', ['Transfer', 'Tunai'])->default('Transfer');
            $table->string('bukti_bayar', 255)->nullable();
            $table->timestamp('tgl_daftar')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
