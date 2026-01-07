<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CicilanJemaah;
use App\Models\Jemaah;
use Faker\Factory as Faker;
use Carbon\Carbon;

class CicilanJemaahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $jemaahs = Jemaah::all();

        foreach ($jemaahs as $jemaah) {
            // Add a payment for some pilgrims
            if (rand(0, 1)) {
                CicilanJemaah::create([
                    'jemaah_id' => $jemaah->id,
                    'kode_cicilan' => 'PAY-' . strtoupper($faker->bothify('?????#####')),
                    'nominal_cicilan' => rand(1000000, 5000000),
                    'tgl_bayar' => Carbon::now()->subDays(rand(1, 10)),
                    'metode_bayar' => $faker->randomElement(['Transfer', 'Tunai']),
                    'bukti_bayar' => 'dummy_receipt.jpg',
                ]);
            }
        }
    }
}
