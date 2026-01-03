<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalKeberangkatan;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar');
    }

    public function getEvents()
    {
        $colors = ['#007bff', '#6610f2', '#6f42c1', '#e83e8c', '#dc3545', '#fd7e14', '#ffc107', '#28a745', '#20c997', '#17a2b8'];

        $events = JadwalKeberangkatan::with('paket')->get()->map(function ($item) use ($colors) {
            $jumlahJemaah = $item->total_kuota - $item->kuota;
            $nama_paket = preg_replace('/^\d+p\s/', '', $item->paket->nama_paket);
            $randomColor = $colors[array_rand($colors)];

            return [
                'title' => $nama_paket . ' (' . $jumlahJemaah . ' Jemaah)',
                'start' => $item->tgl_berangkat,
                'end' => $item->tgl_berangkat,
                'nama_paket' => $nama_paket,
                'jumlah_jemaah' => $jumlahJemaah,
                'backgroundColor' => $randomColor,
                'borderColor' => $randomColor,
            ];
        });

        return response()->json($events);
    }
}