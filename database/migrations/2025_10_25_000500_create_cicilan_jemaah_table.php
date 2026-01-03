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
        Schema::create('cicilan_jemaah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jemaah_id')->constrained('jemaah')->onDelete('cascade');
            $table->string('kode_cicilan', 80)->unique();
            $table->bigInteger('nominal_cicilan');
            $table->timestamp('tgl_bayar')->useCurrent();
            $table->enum('metode_bayar', ['Transfer', 'Tunai'])->default('Transfer');
            $table->string('bukti_bayar', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cicilan_jemaah');
    }
};
