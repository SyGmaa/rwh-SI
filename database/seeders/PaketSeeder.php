<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Paket;
use App\Models\JenisPaket;

class PaketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID jenis paket
        $haji = JenisPaket::where('nama_jenis', 'Haji')->first();
        $umrah = JenisPaket::where('nama_jenis', 'Umrah')->first();

        $paketData = [
            [
                'jenis_id' => 2,
                'nama_paket' => 'Umrah Hemat',
                'harga' => 23000000,
                'jml_hari' => 11,
                'keterangan' => null,
                'is_active' => true,
            ],
            [
                'jenis_id' => 2,
                'nama_paket' => 'Umrah Gledek',
                'harga' => 25500000,
                'jml_hari' => 12,
                'keterangan' => 'Madinah: Al Marsa\r\nMekkah: Rehab Taqwa',
                'is_active' => true,
            ],
            [
                'jenis_id' => 2,
                'nama_paket' => 'Umrah Gledek',
                'harga' => 26000000,
                'jml_hari' => 13,
                'keterangan' => 'Madinah: Al Marsa\r\nMekkah: Rehab Taqwa',
                'is_active' => true,
            ],
            [
                'jenis_id' => 2,
                'nama_paket' => 'Umrah Joss',
                'harga' => 27000000,
                'jml_hari' => 12,
                'keterangan' => 'Madinah: Al Marsa\r\nMekkah: Waha Ajyad \/ Nada Ajyad',
                'is_active' => true,
            ],
            [
                'jenis_id' => 2,
                'nama_paket' => 'Umrah Joss',
                'harga' => 28000000,
                'jml_hari' => 13,
                'keterangan' => 'Madinah: Al Marsa\r\nMekkah: Waha Ajyad \/ Nada Ajyad',
                'is_active' => true,
            ],
            [
                'jenis_id' => 2,
                'nama_paket' => 'Umrah Andalan',
                'harga' => 32000000,
                'jml_hari' => 12,
                'keterangan' => 'Madinah: Al Marsa\r\nMekkah: Azka Safa \/ Prestige Mashaer',
                'is_active' => true,
            ],
            [
                'jenis_id' => 2,
                'nama_paket' => 'Umrah Andalan',
                'harga' => 33000000,
                'jml_hari' => 13,
                'keterangan' => 'Madinah: Al Marsa\r\nMekkah: Azka Safa \/ Prestige Mashaer',
                'is_active' => true,
            ],
            [
                'jenis_id' => 2,
                'nama_paket' => 'Umrah Pintar',
                'harga' => 33000000,
                'jml_hari' => 12,
                'keterangan' => 'Madinah: Royal Madinah \/ Al Marsa\r\nMekkah: Safwa Royal \/ Hilton Tower',
                'is_active' => true,
            ],
            [
                'jenis_id' => 2,
                'nama_paket' => 'Umrah Pintar',
                'harga' => 34000000,
                'jml_hari' => 13,
                'keterangan' => 'Madinah: Royal Madinah \/ Al Marsa\r\nMekkah: Safwa Royal \/ Hilton Tower',
                'is_active' => true,
            ],
            [
                'jenis_id' => 2,
                'nama_paket' => 'Umrah Paten',
                'harga' => 38000000,
                'jml_hari' => 12,
                'keterangan' => 'Madinah: Al Marsa\r\nMekkah: Safwa Royal \/ Hilton Tower',
                'is_active' => true,
            ],
            [
                'jenis_id' => 2,
                'nama_paket' => 'Umrah Paten',
                'harga' => 39000000,
                'jml_hari' => 13,
                'keterangan' => 'Madinah: Al Marsa\r\nMekkah: Safwa Royal \/ Hilton Tower',
                'is_active' => true,
            ],
            [
                'jenis_id' => 2,
                'nama_paket' => 'Umrah Sakinah',
                'harga' => 26000000,
                'jml_hari' => 12,
                'keterangan' => 'Madinah: Al Marsa\r\nMekkah: Hilton Tower',
                'is_active' => true,
            ],
            [
                'jenis_id' => 1,
                'nama_paket' => 'Paket Haji Plus',
                'harga' => 45000000,
                'jml_hari' => 30,
                'keterangan' => 'Paket Haji lengkap dengan akomodasi bintang 4 dan transportasi VIP.',
                'is_active' => true,
            ],
            [
                'jenis_id' => 1,
                'nama_paket' => 'Paket Haji Ekonomis',
                'harga' => 35000000,
                'jml_hari' => 25,
                'keterangan' => 'Paket Haji dengan akomodasi standar dan transportasi reguler.',
                'is_active' => true,
            ],
            [
                'jenis_id' => 2,
                'nama_paket' => 'Paket Umrah Premium',
                'harga' => 25000000,
                'jml_hari' => 12,
                'keterangan' => 'Paket Umrah dengan hotel mewah dan layanan VIP.',
                'is_active' => true,
            ],
            [
                'jenis_id' => 2,
                'nama_paket' => 'Paket Umrah Standar',
                'harga' => 18000000,
                'jml_hari' => 10,
                'keterangan' => 'Paket Umrah dengan akomodasi nyaman dan transportasi standar.',
                'is_active' => true,
            ],
        ];

        foreach ($paketData as $data) {
            Paket::create($data);
        }
    }
}
