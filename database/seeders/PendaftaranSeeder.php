<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pendaftaran;
use App\Models\JadwalKeberangkatan;
use App\Models\Jemaah;
use Faker\Factory as Faker;
use Carbon\Carbon;

class PendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $jadwals = JadwalKeberangkatan::all();

        if ($jadwals->isEmpty()) {
            return;
        }

        foreach ($jadwals as $jadwal) {
            // Create 5 registrations per schedule
            for ($i = 0; $i < 5; $i++) {
                $tglDaftar = Carbon::now()->subDays(rand(1, 30));

                // Create Pendaftaran
                $pendaftaran = Pendaftaran::create([
                    'jadwal_id' => $jadwal->id,
                    'tgl_daftar' => $tglDaftar,
                    'nama_pendaftar' => $faker->name(),
                    'no_tlp' => $faker->phoneNumber(),
                    'dp' => 5000000,
                    'metode_bayar' => $faker->randomElement(['Transfer', 'Tunai']),
                    'bukti_bayar' => 'dummy_bukti.jpg',
                ]);

                // Create Head Jemaah (Pilgrim)
                Jemaah::create([
                    'pendaftaran_id' => $pendaftaran->id,
                    'nama_jemaah' => $faker->name(),
                    'no_tlp' => $faker->phoneNumber(),
                    'pax' => 1,
                    'status_berkas' => $faker->randomElement(['Lengkap', 'Belum Lengkap']),
                    'status_pembayaran' => $faker->randomElement(['Belum Lunas', 'Lunas']),
                ]);

                // Occasionally add a family member
                if (rand(0, 1)) {
                    Jemaah::create([
                        'pendaftaran_id' => $pendaftaran->id,
                        'nama_jemaah' => $faker->name(),
                        'no_tlp' => $faker->phoneNumber(),
                        'pax' => 1,
                        'status_berkas' => 'Belum Lengkap',
                        'status_pembayaran' => 'Belum Lunas',
                    ]);
                }
            }
        }
    }
}
