<?php

namespace App\Http\Controllers;

use App\Models\Jemaah;
use App\Models\JadwalKeberangkatan;
use App\Models\CicilanJemaah;
use App\Models\Pendaftaran;
use App\Models\Paket;
use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function getChartData(Request $request)
    {
        $filter = $request->input('filter', '1_year');
        $pickedMonth = $request->input('month');

        $now = Carbon::now();
        $labels = [];
        $series = [];

        // Determine date range and label format based on filter
        if ($filter == 'this_month') {
            $startDate = $now->copy()->startOfMonth();
            $endDate = $now->copy()->endOfMonth();
        } elseif ($filter == 'pick_month' && $pickedMonth) {
            $date = Carbon::createFromFormat('Y-m', $pickedMonth);
            $startDate = $date->copy()->startOfMonth();
            $endDate = $date->copy()->endOfMonth();
        } elseif ($filter == '6_months') {
            $startDate = $now->copy()->subMonths(5)->startOfMonth(); // Current + 5 prev months
            $endDate = $now->copy()->endOfMonth();
        } else { // 1_year (Default)
            // Use current year Jan-Dec as per original logic, or last 12 months?
            // Original logic used: 
            // $currentYear = $now->year;
            // $monthlyData ... whereYear(..., date('Y'))
            // So default behavior is "Current Year" (Jan-Dec).
            $startDate = $now->copy()->startOfYear();
            $endDate = $now->copy()->endOfYear();
        }

        // Get Top Packages (Reuse logic or simplify)
        // Note: For "pick_month" or "this_month", we might want top packages effective in that month,
        // but to keep consistency with the "Top Packages" concept which is usually an annual or general metric,
        // we might stick to top packages of the *current year* or *target period*.
        // Let's use the top packages of the *current year* to ensure the series names remain consistent often,
        // or we can strictly filter by the selected range.
        // Let's stick to the current logic: Top 3 packages of the current year.

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

        $topPakets = Paket::whereIn('id', $topPaketIds)->get();

        // Prepare Data Query
        if ($filter == 'this_month' || $filter == 'pick_month') {
            // Daily Data
            $daysInMonth = $endDate->day;
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $labels[] = $i; // just day number
            }

            // Fetch daily stats
            $dailyData = Jemaah::select(
                DB::raw('DAY(jadwal_keberangkatan.tgl_berangkat) as day'),
                'jadwal_keberangkatan.paket_id',
                DB::raw('COUNT(jemaah.id) as total_jemaah')
            )
                ->join('pendaftaran', 'jemaah.pendaftaran_id', '=', 'pendaftaran.id')
                ->join('jadwal_keberangkatan', 'pendaftaran.jadwal_id', '=', 'jadwal_keberangkatan.id')
                ->whereIn('jadwal_keberangkatan.paket_id', $topPaketIds)
                ->whereBetween('jadwal_keberangkatan.tgl_berangkat', [$startDate, $endDate])
                ->groupByRaw('day, jadwal_keberangkatan.paket_id')
                ->get();

            foreach ($topPakets as $paket) {
                $data = array_fill(0, $daysInMonth, 0);
                foreach ($dailyData as $row) {
                    if ($row->paket_id == $paket->id) {
                        $data[$row->day - 1] = $row->total_jemaah;
                    }
                }
                $series[] = [
                    'name' => $paket->nama_paket,
                    'data' => $data,
                ];
            }
        } else {
            // Monthly Data
            // Generate Labels
            $period = \Carbon\CarbonPeriod::create($startDate, '1 month', $endDate);
            foreach ($period as $dt) {
                $labels[] = $dt->format('F');
            }
            $monthCount = count($labels);

            $monthlyData = Jemaah::select(
                DB::raw('MONTH(jadwal_keberangkatan.tgl_berangkat) as month'),
                DB::raw('YEAR(jadwal_keberangkatan.tgl_berangkat) as year'),
                'jadwal_keberangkatan.paket_id',
                DB::raw('COUNT(jemaah.id) as total_jemaah')
            )
                ->join('pendaftaran', 'jemaah.pendaftaran_id', '=', 'pendaftaran.id')
                ->join('jadwal_keberangkatan', 'pendaftaran.jadwal_id', '=', 'jadwal_keberangkatan.id')
                ->whereIn('jadwal_keberangkatan.paket_id', $topPaketIds)
                ->whereBetween('jadwal_keberangkatan.tgl_berangkat', [$startDate, $endDate])
                ->groupByRaw('year, month, jadwal_keberangkatan.paket_id')
                ->get();

            foreach ($topPakets as $paket) {
                $data = array_fill(0, $monthCount, 0);
                $i = 0;
                foreach ($period as $dt) {
                    $m = $dt->month;
                    $y = $dt->year;
                    // Find data for this month/year
                    $val = 0;
                    foreach ($monthlyData as $row) {
                        if ($row->paket_id == $paket->id && $row->month == $m && $row->year == $y) {
                            $val = $row->total_jemaah;
                            break;
                        }
                    }
                    $data[$i] = $val;
                    $i++;
                }
                $series[] = [
                    'name' => $paket->nama_paket,
                    'data' => $data,
                ];
            }
        }

        return response()->json([
            'labels' => $labels,
            'series' => $series
        ]);
    }

    public function getTopPackagesData(Request $request)
    {
        $filter = $request->input('filter', 'this_year');
        $pickedMonth = $request->input('month');

        $now = Carbon::now();
        $startDate = $now->copy()->startOfYear();
        $endDate = $now->copy()->endOfYear();
        $label = 'Tahun Ini (' . $now->year . ')';

        if ($filter == 'this_month') {
            $startDate = $now->copy()->startOfMonth();
            $endDate = $now->copy()->endOfMonth();
            $label = 'Bulan Ini (' . $now->format('F Y') . ')';
        } elseif ($filter == 'pick_month' && $pickedMonth) {
            $date = Carbon::createFromFormat('Y-m', $pickedMonth);
            $startDate = $date->copy()->startOfMonth();
            $endDate = $date->copy()->endOfMonth();
            $label = $date->format('F Y');
        }

        // Top 5 Selling Packages logic
        $topSellingPackages = Paket::select(
            'paket.id',
            'paket.nama_paket',
            'paket.harga',
            DB::raw('COUNT(jemaah.id) as total_sales')
        )
            ->join('jadwal_keberangkatan', 'paket.id', '=', 'jadwal_keberangkatan.paket_id')
            ->join('pendaftaran', 'jadwal_keberangkatan.id', '=', 'pendaftaran.jadwal_id')
            ->join('jemaah', 'pendaftaran.id', '=', 'jemaah.pendaftaran_id')
            ->whereBetween('jadwal_keberangkatan.tgl_berangkat', [$startDate, $endDate])
            ->groupBy('paket.id', 'paket.nama_paket', 'paket.harga')
            ->orderByDesc('total_sales')
            ->take(5)
            ->get()
            ->map(function ($paket) {
                // Calculate estimated revenue
                $paket->revenue = $paket->total_sales * $paket->harga;
                $paket->formatted_revenue = number_format($paket->revenue, 0, ',', '.');
                return $paket;
            });

        // Calculate max revenue for progress bar percentage
        $maxRevenue = $topSellingPackages->max('revenue');
        $topSellingPackages->transform(function ($paket) use ($maxRevenue) {
            $paket->revenue_percentage = $maxRevenue > 0 ? ($paket->revenue / $maxRevenue) * 100 : 0;
            return $paket;
        });

        return response()->json([
            'data' => $topSellingPackages,
            'label' => $label
        ]);
    }

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

        // Send Reminder Notification (Guarded by Cache for 6 hours to avoid spam)
        if ($jemaahs->count() > 0 && !Cache::has('payment_reminder_sent')) {
            $admins = User::all();
            $message = "PENGINGAT: Ada " . $jemaahs->count() . " jemaah dengan keberangkatan < 30 hari yang belum lunas atau berkas belum lengkap.";
            // Link to a filtered view or just the dashboard
            Notification::send($admins, new SystemNotification($message, route('dashboard')));
            Cache::put('payment_reminder_sent', true, now()->addHours(6));
        }

        // Quota Progress Data (Active/Future Schedules)
        $quotaSchedules = JadwalKeberangkatan::with('paket')
            ->where('tgl_berangkat', '>=', Carbon::now())
            ->where('status', '!=', 'Selesai')
            ->orderBy('tgl_berangkat', 'asc')
            ->take(5)
            ->get()
            ->map(function ($jadwal) {
                $terisi = Jemaah::whereHas('pendaftaran', function ($q) use ($jadwal) {
                    $q->where('jadwal_id', $jadwal->id);
                })->where('status_pembayaran', '!=', 'Dibatalkan')->count();

                $jadwal->terisi = $terisi;
                $jadwal->persentase = $jadwal->total_kuota > 0 ? round(($terisi / $jadwal->total_kuota) * 100) : 0;

                // Auto-update status to Sold Out if full
                if ($jadwal->persentase >= 100 && $jadwal->status != 'Sold Out') {
                    $jadwal->update(['status' => 'Sold Out']);
                }

                return $jadwal;
            });

        // Passport Expiry Warning (Static check for now since no tgl_passport in schema yet)
        // Note: In real app, we'd check against a specific passport_expiry column
        $passportWarnings = []; // Placeholder until column exists

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

        // Top 5 Selling Packages (This Year)
        $topSellingPackages = Paket::select(
            'paket.id',
            'paket.nama_paket',
            'paket.harga',
            DB::raw('COUNT(jemaah.id) as total_sales')
        )
            ->join('jadwal_keberangkatan', 'paket.id', '=', 'jadwal_keberangkatan.paket_id')
            ->join('pendaftaran', 'jadwal_keberangkatan.id', '=', 'pendaftaran.jadwal_id')
            ->join('jemaah', 'pendaftaran.id', '=', 'jemaah.pendaftaran_id')
            ->whereYear('jadwal_keberangkatan.tgl_berangkat', Carbon::now()->year)
            ->groupBy('paket.id', 'paket.nama_paket', 'paket.harga')
            ->orderByDesc('total_sales')
            ->take(5)
            ->get()
            ->map(function ($paket) {
                // Calculate estimated revenue: Sales Count * Package Price
                // Note: This is an estimation. Real revenue might include extra costs or discounts.
                $paket->revenue = $paket->total_sales * $paket->harga;
                return $paket;
            });
        // Calculate max revenue for progress bar percentage
        $maxRevenue = $topSellingPackages->max('revenue');
        $topSellingPackages->transform(function ($paket) use ($maxRevenue) {
            $paket->revenue_percentage = $maxRevenue > 0 ? ($paket->revenue / $maxRevenue) * 100 : 0;
            return $paket;
        });

        // Recent Activities (Latest 5)
        $recentActivities = \App\Models\ActivityLogSpatie::with('causer')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Format Currency Short
        $totalPemasukanCurrentFormatted = $this->formatIdrShort($totalPemasukanCurrent);
        $totalPemasukanWeekFormatted = $this->formatIdrShort($totalPemasukanWeek);
        $totalPemasukanYearFormatted = $this->formatIdrShort($totalPemasukanYear);

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
            'totalPemasukanCurrentFormatted',
            'totalPemasukanWeekFormatted',
            'totalPemasukanYearFormatted',
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
            'topSellingPackages',
            'recentActivities',
            'quotaSchedules'
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

    private function formatIdrShort($number)
    {
        if ($number >= 1000000000000) {
            return number_format($number / 1000000000000, 2, ',', '.') . ' Triliun';
        } elseif ($number >= 1000000000) {
            return number_format($number / 1000000000, 2, ',', '.') . ' Milyar';
        } elseif ($number >= 1000000) {
            return number_format($number / 1000000, 0, ',', '.') . ' Juta';
        }
        return 'Rp ' . number_format($number, 0, ',', '.');
    }
}
