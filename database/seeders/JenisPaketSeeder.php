<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisPaket;

class JenisPaketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisPaketData = [
            [
                'nama_jenis' => 'Haji',
                'deskripsi' => 'Paket perjalanan ibadah Haji ke Tanah Suci',
                'is_active' => true,
            ],
            [
                'nama_jenis' => 'Umrah',
                'deskripsi' => 'Paket perjalanan ibadah Umrah ke Tanah Suci',
                'is_active' => true,
            ],
        ];

        foreach ($jenisPaketData as $data) {
            JenisPaket::create($data);
        }
    }
}
