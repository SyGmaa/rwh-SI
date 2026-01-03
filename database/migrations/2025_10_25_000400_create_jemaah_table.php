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
        Schema::create('jemaah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran')->onDelete('cascade');
            $table->string('nama_jemaah', 255);
            $table->string('no_tlp', 20)->nullable();
            $table->integer('pax')->default(4);
            $table->bigInteger('biaya_tambahan')->default(0);
            $table->foreignId('jadwal_override_id')->nullable()->constrained('jadwal_keberangkatan')->onDelete('set null');
            $table->enum('status_berkas', ['Lengkap', 'Belum Lengkap'])->default('Belum Lengkap');
            $table->enum('status_pembayaran', ['Belum Lunas', 'Lunas', 'Dibatalkan'])->default('Belum Lunas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jemaah');
    }
};
