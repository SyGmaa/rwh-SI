<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jemaah;
use App\Models\Paket;
use App\Models\JadwalKeberangkatan;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return redirect()->back();
        }

        $jemaah = Jemaah::where('nama_jemaah', 'like', "%{$query}%")
                        ->get();

        $paket = Paket::where('nama_paket', 'like', "%{$query}%")
                      ->with('jenisPaket')
                      ->get();

        $jadwal = JadwalKeberangkatan::whereHas('paket', function($q) use ($query) {
                        $q->where('nama_paket', 'like', "%{$query}%");
                    })
                    ->orWhere('tgl_berangkat', 'like', "%{$query}%")
                    ->with('paket')
                    ->get();

        return view('search.index', compact('jemaah', 'paket', 'jadwal', 'query'));
    }
}
