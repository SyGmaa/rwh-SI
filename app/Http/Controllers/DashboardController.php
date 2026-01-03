<?php

namespace App\Http\Controllers;

use App\Models\Jemaah;
use App\Models\JadwalKeberangkatan;
use App\Models\CicilanJemaah;
use App\Models\Pendaftaran;
use App\Models\Paket;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $currentMonthStart = $now->copy()->startOfMonth();
        $currentMonthEnd = $now->copy()->endOfMonth();
        $prevMonthStart = $now->copy()->subYear()->startOfMonth();
        $prevMonthEnd = $now->copy()->subYear()->endOfMonth();

        // Total Jadwal Bulan Ini
        $totalJadwalCurrent = JadwalKeberangkatan::whereBetween('tgl_berangkat', [$currentMonthStart, $currentMonthEnd])->count();
        $totalJadwalPrev = JadwalKeberangkatan::whereBetween('tgl_berangkat', [$prevMonthStart, $prevMonthEnd])->count();
        $jadwalChange = $this->calculateChange($totalJadwalCurrent, $totalJadwalPrev);

        // Total Jemaah Bulan Ini
        $totalJemaahCurrent = Jemaah::whereHas('pendaftaran.jadwalKeberangkatan', function ($q) use ($currentMonthStart, $currentMonthEnd) {
            $q->whereBetween('tgl_berangkat', [$currentMonthStart, $currentMonthEnd]);
        })->count();
        $totalJemaahPrev = Jemaah::whereHas('pendaftaran.jadwalKeberangkatan', function ($q) use ($prevMonthStart, $prevMonthEnd) {
            $q->whereBetween('tgl_berangkat', [$prevMonthStart, $prevMonthEnd]);
        })->count();
        $jemaahChange = $this->calculateChange($totalJemaahCurrent, $totalJemaahPrev);

        // Total Jemaah yang Batal
        $totalBatalCurrent = Jemaah::where('status_pembayaran', 'Dibatalkan')
            ->whereHas('pendaftaran', function ($q) use ($currentMonthStart, $currentMonthEnd) {
                $q->whereBetween('tgl_daftar', [$currentMonthStart, $currentMonthEnd]);
            })->count();
        $totalBatalPrev = Jemaah::where('status_pembayaran', 'Dibatalkan')
            ->whereHas('pendaftaran', function ($q) use ($prevMonthStart, $prevMonthEnd) {
                $q->whereBetween('tgl_daftar', [$prevMonthStart, $prevMonthEnd]);
            })->count();
        $batalChange = $this->calculateChange($totalBatalCurrent, $totalBatalPrev);

        // Total Pemasukan
        // Total Pemasukan Monthly
        $totalPemasukanCurrent = $this->calculatePemasukan($currentMonthStart, $currentMonthEnd);
        $totalPemasukanPrev = $this->calculatePemasukan($prevMonthStart, $prevMonthEnd);
        $pemasukanChange = $this->calculateChange($totalPemasukanCurrent, $totalPemasukanPrev);

        // Total Pemasukan Weekly
        $currentWeekStart = $now->copy()->startOfWeek();
        $currentWeekEnd = $now->copy()->endOfWeek();
        $prevWeekStart = $now->copy()->subWeek()->startOfWeek();
        $prevWeekEnd = $now->copy()->subWeek()->endOfWeek();

        $totalPemasukanWeek = $this->calculatePemasukan($currentWeekStart, $currentWeekEnd);
        $totalPemasukanPrevWeek = $this->calculatePemasukan($prevWeekStart, $prevWeekEnd);
        $pemasukanWeekChange = $this->calculateChange($totalPemasukanWeek, $totalPemasukanPrevWeek);

        // Total Pemasukan Yearly
        $currentYearStart = $now->copy()->startOfYear();
        $currentYearEnd = $now->copy()->endOfYear();
        $prevYearStart = $now->copy()->subYear()->startOfYear();
        $prevYearEnd = $now->copy()->subYear()->endOfYear();

        $totalPemasukanYear = $this->calculatePemasukan($currentYearStart, $currentYearEnd);
        $totalPemasukanPrevYear = $this->calculatePemasukan($prevYearStart, $prevYearEnd);
        $pemasukanYearChange = $this->calculateChange($totalPemasukanYear, $totalPemasukanPrevYear);

        // Fetch jemaah with close departure dates and incomplete status
        $jemaahs = Jemaah::with('pendaftaran.jadwalKeberangkatan.paket.jenisPaket')
            ->whereHas('pendaftaran.jadwalKeberangkatan', function ($q) {
                $q->where('tgl_berangkat', '>=', Carbon::now())
                    ->where('tgl_berangkat', '<=', Carbon::now()->addDays(30));
            })
            ->where(function ($q) {
                $q->where('status_berkas', 'Belum Lengkap')
                    ->orWhere('status_pembayaran', 'Belum Lunas');
            })
            ->get();

        $currentYear = $now->year;
        $topPaketIds = Paket::select('paket.id')
            ->join('jadwal_keberangkatan', 'paket.id', '=', 'jadwal_keberangkatan.paket_id')
            ->join('pendaftaran', 'jadwal_keberangkatan.id', '=', 'pendaftaran.jadwal_id')
            ->join('jemaah', 'pendaftaran.id', '=', 'jemaah.pendaftaran_id')
            ->whereYear('jadwal_keberangkatan.tgl_berangkat', $currentYear)
            ->groupBy('paket.id')
            ->orderByDesc(DB::raw('COUNT(jemaah.id)'))
            ->limit(3)
            ->pluck('id');

        $monthlyData = Jemaah::select(
            DB::raw('MONTH(jadwal_keberangkatan.tgl_berangkat) as month'),
            'jadwal_keberangkatan.paket_id',
            DB::raw('COUNT(jemaah.id) as total_jemaah')
        )
            ->join('pendaftaran', 'jemaah.pendaftaran_id', '=', 'pendaftaran.id')
            ->join('jadwal_keberangkatan', 'pendaftaran.jadwal_id', '=', 'jadwal_keberangkatan.id')
            ->whereIn('jadwal_keberangkatan.paket_id', $topPaketIds)
            ->whereYear('jadwal_keberangkatan.tgl_berangkat', date('Y'))
            ->groupBy('month', 'jadwal_keberangkatan.paket_id')
            ->get();

        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = date('F', mktime(0, 0, 0, $i, 1));
        }

        $series = [];
        $topPakets = Paket::whereIn('id', $topPaketIds)->get();

        foreach ($topPakets as $paket) {
            $data = array_fill(0, 12, 0);
            foreach ($monthlyData as $row) {
                if ($row->paket_id == $paket->id) {
                    $data[$row->month - 1] = $row->total_jemaah;
                }
            }
            $series[] = [
                'name' => $paket->nama_paket,
                'data' => $data,
            ];
        }

        $chartData = [
            'labels' => $months,
            'series' => $series,
        ];

        // Yearly Statistics
        $currentYear = $now->year;
        $prevYear = $currentYear - 1;

        // Average pilgrims per month this year
        $totalJemaahYear = Jemaah::whereHas('pendaftaran.jadwalKeberangkatan', function ($q) use ($currentYear) {
            $q->whereYear('tgl_berangkat', $currentYear);
        })->count();
        $avgJemaahPerMonth = $totalJemaahYear / 12;

        $totalJemaahPrevYear = Jemaah::whereHas('pendaftaran.jadwalKeberangkatan', function ($q) use ($prevYear) {
            $q->whereYear('tgl_berangkat', $prevYear);
        })->count();
        $avgJemaahPerMonthPrev = $totalJemaahPrevYear / 12;
        $avgJemaahChange = $this->calculateChange($avgJemaahPerMonth, $avgJemaahPerMonthPrev);

        // Highest pilgrims in one month this year
        $highestJemaahMonth = Jemaah::select(DB::raw('MONTH(jadwal_keberangkatan.tgl_berangkat) as month'), DB::raw('COUNT(jemaah.id) as total'))
            ->join('pendaftaran', 'jemaah.pendaftaran_id', '=', 'pendaftaran.id')
            ->join('jadwal_keberangkatan', 'pendaftaran.jadwal_id', '=', 'jadwal_keberangkatan.id')
            ->whereYear('jadwal_keberangkatan.tgl_berangkat', $currentYear)
            ->groupBy('month')
            ->orderByDesc('total')
            ->first();
        $highestJemaah = $highestJemaahMonth ? $highestJemaahMonth->total : 0;

        $highestJemaahPrevYear = Jemaah::select(DB::raw('MONTH(jadwal_keberangkatan.tgl_berangkat) as month'), DB::raw('COUNT(jemaah.id) as total'))
            ->join('pendaftaran', 'jemaah.pendaftaran_id', '=', 'pendaftaran.id')
            ->join('jadwal_keberangkatan', 'pendaftaran.jadwal_id', '=', 'jadwal_keberangkatan.id')
            ->whereYear('jadwal_keberangkatan.tgl_berangkat', $prevYear)
            ->groupBy('month')
            ->orderByDesc('total')
            ->first();
        $highestJemaahPrev = $highestJemaahPrevYear ? $highestJemaahPrevYear->total : 0;
        $highestJemaahChange = $this->calculateChange($highestJemaah, $highestJemaahPrev);

        // Lowest pilgrims in one month this year
        $lowestJemaahMonth = Jemaah::select(DB::raw('MONTH(jadwal_keberangkatan.tgl_berangkat) as month'), DB::raw('COUNT(jemaah.id) as total'))
            ->join('pendaftaran', 'jemaah.pendaftaran_id', '=', 'pendaftaran.id')
            ->join('jadwal_keberangkatan', 'pendaftaran.jadwal_id', '=', 'jadwal_keberangkatan.id')
            ->whereYear('jadwal_keberangkatan.tgl_berangkat', $currentYear)
            ->groupBy('month')
            ->orderBy('total')
            ->first();
        $lowestJemaah = $lowestJemaahMonth ? $lowestJemaahMonth->total : 0;

        $lowestJemaahPrevYear = Jemaah::select(DB::raw('MONTH(jadwal_keberangkatan.tgl_berangkat) as month'), DB::raw('COUNT(jemaah.id) as total'))
            ->join('pendaftaran', 'jemaah.pendaftaran_id', '=', 'pendaftaran.id')
            ->join('jadwal_keberangkatan', 'pendaftaran.jadwal_id', '=', 'jadwal_keberangkatan.id')
            ->whereYear('jadwal_keberangkatan.tgl_berangkat', $prevYear)
            ->groupBy('month')
            ->orderBy('total')
            ->first();
        $lowestJemaahPrev = $lowestJemaahPrevYear ? $lowestJemaahPrevYear->total : 0;
        $lowestJemaahChange = $this->calculateChange($lowestJemaah, $lowestJemaahPrev);

        // Total departures this year
        $totalKeberangkatanYear = JadwalKeberangkatan::whereYear('tgl_berangkat', $currentYear)->count();
        $totalKeberangkatanPrevYear = JadwalKeberangkatan::whereYear('tgl_berangkat', $prevYear)->count();
        $keberangkatanChange = $this->calculateChange($totalKeberangkatanYear, $totalKeberangkatanPrevYear);

        // Total pilgrims this year (already calculated as $totalJemaahYear)
        $totalJemaahChange = $this->calculateChange($totalJemaahYear, $totalJemaahPrevYear);

        // Upcoming Schedules (Next 5)
        $upcomingSchedules = JadwalKeberangkatan::with(['paket', 'pendaftaran'])
            ->where('tgl_berangkat', '>=', Carbon::now())
            ->orderBy('tgl_berangkat', 'asc')
            ->take(5)
            ->get();

        // Recent Activities (Latest 5)
        $recentActivities = \App\Models\ActivityLogSpatie::with('causer')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('welcome', compact(
            'jemaahs',
            'totalJadwalCurrent',
            'jadwalChange',
            'totalJemaahCurrent',
            'jemaahChange',
            'totalBatalCurrent',
            'batalChange',
            'totalPemasukanCurrent',
            'pemasukanChange',
            'chartData',
            'avgJemaahPerMonth',
            'avgJemaahChange',
            'highestJemaah',
            'highestJemaahChange',
            'lowestJemaah',
            'lowestJemaahChange',
            'totalKeberangkatanYear',
            'keberangkatanChange',
            'totalJemaahYear',
            'totalJemaahChange',
            'totalPemasukanWeek',
            'pemasukanWeekChange',
            'totalPemasukanYear',
            'pemasukanYearChange',
            'upcomingSchedules',
            'recentActivities'
        ));
    }

    private function calculateChange($current, $prev)
    {
        if ($prev == 0) {
            return $current > 0 ? ['percentage' => 100, 'type' => 'increase'] : ['percentage' => 0, 'type' => 'neutral'];
        }
        $change = (($current - $prev) / $prev) * 100;
        $type = $change >= 0 ? 'increase' : 'decrease';
        return ['percentage' => abs($change), 'type' => $type];
    }

    private function calculatePemasukan($startDate, $endDate)
    {
        $pemasukanDp = Pendaftaran::whereBetween('tgl_daftar', [$startDate, $endDate])->sum('dp');
        $pemasukanCicilan = CicilanJemaah::whereBetween('tgl_bayar', [$startDate, $endDate])->sum('nominal_cicilan');
        return $pemasukanDp + $pemasukanCicilan;
    }
}
