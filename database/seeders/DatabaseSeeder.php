<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisPaket;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Users
        $this->call(UserSeeder::class);

        // Seed Settings
        $this->call(SettingSeeder::class);

        // Seed JenisPaket
        $this->call(JenisPaketSeeder::class);

        // Seed Paket
        $this->call(PaketSeeder::class);

        // Seed Jadwal
        $this->call(JadwalKeberangkatanSeeder::class);

        // Seed JenisDokumen
        $this->call(JenisDokumenSeeder::class);

        // Seed Pendaftaran & Jemaah
        $this->call(PendaftaranSeeder::class);

        // Seed Cicilan
        $this->call(CicilanJemaahSeeder::class);

        // Seed Dokumen Jemaah
        $this->call(DokumenJemaahSeeder::class);
    }
}
