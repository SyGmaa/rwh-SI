<?php

namespace App\Http\Controllers;

use App\Models\CicilanJemaah; // Assuming this model exists and maps to cicilan_jemaah table
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanKeuanganController extends Controller
{
    public function index()
    {
        $totalPemasukan = CicilanJemaah::sum('nominal_cicilan');

        $pemasukanBulanIni = CicilanJemaah::whereMonth('tgl_bayar', Carbon::now()->month)
            ->whereYear('tgl_bayar', Carbon::now()->year)
            ->sum('nominal_cicilan');

        $transaksiTerbaru = CicilanJemaah::with('jemaah') // Assuming relationship exists
            ->latest('tgl_bayar')
            ->take(10)
            ->get();

        return view('admin.laporan-keuangan.index', compact('totalPemasukan', 'pemasukanBulanIni', 'transaksiTerbaru'));
    }

    public function exportExcel()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Jemaah');
        $sheet->setCellValue('C1', 'Nominal');
        $sheet->setCellValue('D1', 'Tanggal Bayar');
        $sheet->setCellValue('E1', 'Metode');
        $sheet->setCellValue('F1', 'Kode Cicilan');

        $transaksi = CicilanJemaah::with('jemaah')->latest('tgl_bayar')->get();
        $row = 2;
        foreach ($transaksi as $index => $t) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $t->jemaah->nama_jemaah ?? 'N/A');
            $sheet->setCellValue('C' . $row, $t->nominal_cicilan);
            $sheet->setCellValue('D' . $row, $t->tgl_bayar);
            $sheet->setCellValue('E' . $row, $t->metode_bayar);
            $sheet->setCellValue('F' . $row, $t->kode_cicilan);
            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'Laporan_Keuangan_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        $writer->save('php://output');
        exit;
    }

    public function exportPdf()
    {
        $transaksi = CicilanJemaah::with('jemaah')->latest('tgl_bayar')->get();
        $totalPemasukan = $transaksi->sum('nominal_cicilan');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan-keuangan.pdf', compact('transaksi', 'totalPemasukan'));
        return $pdf->download('Laporan_Keuangan_' . date('Ymd_His') . '.pdf');
    }
}
