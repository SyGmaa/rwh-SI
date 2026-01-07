<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalKeberangkatan;
use App\Models\Paket;
use Carbon\Carbon;

class JadwalKeberangkatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pakets = Paket::all();

        if ($pakets->isEmpty()) {
            return;
        }

        // Generate schedule for 12 months (6 months back, 6 months forward)
        // This ensures every month has a departure
        $startWindow = Carbon::now()->subMonths(6)->startOfMonth();
        $endWindow = Carbon::now()->addMonths(6)->startOfMonth();

        foreach ($pakets as $paket) {
            $currentDate = $startWindow->copy();

            while ($currentDate <= $endWindow) {
                // Determine status based on date
                $status = 'Tersedia';
                if ($currentDate->isPast()) {
                    $status = 'Selesai';
                }

                // Randomly set a specific month as 'Penuh' for variety, if it's in the future
                if ($currentDate->isFuture() && rand(0, 100) < 20) {
                    $status = 'Penuh';
                }

                JadwalKeberangkatan::create([
                    'paket_id' => $paket->id,
                    'tgl_berangkat' => $currentDate->copy()->addDays(rand(5, 25)), // Random day in that month
                    'total_kuota' => 45,
                    'kuota' => ($status === 'Penuh' || $status === 'Selesai') ? 0 : 45,
                    'status' => $status,
                    'keterangan' => 'Keberangkatan Periode ' . $currentDate->format('F Y'),
                ]);

                $currentDate->addMonth();
            }
        }
    }
}
