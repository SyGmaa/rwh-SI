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
        Schema::create('dokumen_jemaah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jemaah_id')->constrained('jemaah')->onDelete('cascade');
            $table->foreignId('jenis_id')->constrained('jenis_dokumen')->onDelete('restrict');
            $table->string('file_path', 255);
            $table->timestamp('tanggal_upload')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_jemaah');
    }
};
