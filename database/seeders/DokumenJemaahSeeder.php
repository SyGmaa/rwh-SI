<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DokumenJemaah;
use App\Models\Jemaah;
use App\Models\JenisDokumen;
use Carbon\Carbon;

class DokumenJemaahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jemaahs = Jemaah::all();
        $jenisDokumens = JenisDokumen::all();

        if ($jenisDokumens->isEmpty()) {
            return;
        }

        foreach ($jemaahs as $jemaah) {
            // Upload KTP (Assuming type 1 exists or first one)
            $ktpType = $jenisDokumens->firstWhere('nama_jenis', 'KTP') ?? $jenisDokumens->first();

            if ($ktpType) {
                DokumenJemaah::create([
                    'jemaah_id' => $jemaah->id,
                    'jenis_id' => $ktpType->id,
                    'file_path' => 'documents/dummy_ktp.jpg',
                    'tanggal_upload' => Carbon::now(),
                ]);
            }

            // Upload Passport for some
            $pasporType = $jenisDokumens->firstWhere('nama_jenis', 'Paspor');
            if ($pasporType && rand(0, 1)) {
                DokumenJemaah::create([
                    'jemaah_id' => $jemaah->id,
                    'jenis_id' => $pasporType->id,
                    'file_path' => 'documents/dummy_paspor.jpg',
                    'tanggal_upload' => Carbon::now(),
                ]);
            }
        }
    }
}
