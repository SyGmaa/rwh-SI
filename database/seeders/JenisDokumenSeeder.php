<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisDokumen;

class JenisDokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisDokumenData = [
            [
                'nama_jenis' => 'KTP',
                'deskripsi' => null,
                'wajib_upload' => true,
                'is_active' => true,
            ],
            [
                'nama_jenis' => 'KK',
                'deskripsi' => null,
                'wajib_upload' => true,
                'is_active' => true,
            ],
            [
                'nama_jenis' => 'Paspor',
                'deskripsi' => null,
                'wajib_upload' => true,
                'is_active' => true,
            ],
            [
                'nama_jenis' => 'Kartu Vaksin',
                'deskripsi' => null,
                'wajib_upload' => true,
                'is_active' => true,
            ],
        ];

        foreach ($jenisDokumenData as $data) {
            JenisDokumen::create($data);
        }
    }
}
