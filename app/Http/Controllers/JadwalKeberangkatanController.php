<?php

namespace App\Http\Controllers;

use App\Models\JadwalKeberangkatan;
use App\Models\Paket;
use App\Models\JenisPaket;
use Illuminate\Http\Request;

class JadwalKeberangkatanController extends Controller
{
    public function index(Request $request)
    {
        $jenisId = $request->get('jenis_id');
        $query = JadwalKeberangkatan::with('paket.jenisPaket');

        if ($jenisId) {
            $query->whereHas('paket', function ($q) use ($jenisId) {
                $q->where('jenis_id', $jenisId);
            });
        }

        $jadwalKeberangkatans = $query->get();
        $jenisPakets = JenisPaket::all();

        return view('jadwal-keberangkatan.index', compact('jadwalKeberangkatans', 'jenisPakets', 'jenisId'));
    }

    public function create(Request $request)
    {
        $jenisId = $request->get('jenis_id');
        $pakets = Paket::where('is_active', 1)->with('jenisPaket')->get();

        if ($jenisId) {
            $pakets = $pakets->where('jenis_id', $jenisId);
        }

        return view('jadwal-keberangkatan.create', compact('pakets', 'jenisId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paket_id' => 'required|exists:paket,id',
            'tgl_berangkat' => 'required|date',
            'kuota' => 'required|integer|min:0',
            'status' => 'required|in:Tersedia,Penuh,Selesai,Dibatalkan',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        $data['total_kuota'] = $request->kuota;
        JadwalKeberangkatan::create($data);

        $paket = Paket::find($request->paket_id);
        return redirect()->route('jadwal-keberangkatan.index', ['jenis_id' => $paket->jenis_id])->with('success', 'Jadwal Keberangkatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwalKeberangkatan = JadwalKeberangkatan::with('paket.jenisPaket')->findOrFail($id);
        $pakets = Paket::where('is_active', 1)->with('jenisPaket')->get();

        return view('jadwal-keberangkatan.edit', compact('jadwalKeberangkatan', 'pakets'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'paket_id' => 'required|exists:paket,id',
            'tgl_berangkat' => 'required|date',
            'kuota' => 'required|integer|min:0',
            'status' => 'required|in:Tersedia,Penuh,Selesai,Dibatalkan',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $jadwalKeberangkatan = JadwalKeberangkatan::findOrFail($id);
        $oldTotalKuota = $jadwalKeberangkatan->total_kuota;
        $newTotalKuota = $request->kuota;
        $difference = $newTotalKuota - $oldTotalKuota;

        $data = $request->all();
        $data['total_kuota'] = $newTotalKuota;
        $data['kuota'] = $jadwalKeberangkatan->kuota + $difference;
        $jadwalKeberangkatan->update($data);

        $paket = Paket::find($request->paket_id);
        return redirect()->route('jadwal-keberangkatan.index', ['jenis_id' => $paket->jenis_id])->with('success', 'Jadwal Keberangkatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwalKeberangkatan = JadwalKeberangkatan::findOrFail($id);
        $paket = $jadwalKeberangkatan->paket;
        $jadwalKeberangkatan->delete();

        return redirect()->route('jadwal-keberangkatan.index', ['jenis_id' => $paket->jenis_id])->with('success', 'Jadwal Keberangkatan berhasil dihapus.');
    }
}
