<?php

namespace App\Http\Controllers;

use App\Models\CicilanJemaah;
use App\Models\JenisPaket;
use Illuminate\Http\Request;

class CicilanJemaahController extends Controller
{
    public function index(Request $request)
    {
        $jenisId = $request->get('jenis_id');
        $jadwalId = $request->get('jadwal_id');
        $query = CicilanJemaah::with('jemaah.pendaftaran.jadwalKeberangkatan.paket.jenisPaket');

        if ($jenisId) {
            $query->whereHas('jemaah.pendaftaran.jadwalKeberangkatan.paket', function ($q) use ($jenisId) {
                $q->where('jenis_id', $jenisId);
            });
        }

        if ($jadwalId) {
            $query->whereHas('jemaah.pendaftaran', function ($q) use ($jadwalId) {
                $q->where('jadwal_id', $jadwalId);
            });
        }

        $cicilanJemaahs = $query->get();
        $jenisPakets = JenisPaket::all();
        $jadwalKeberangkatans = \App\Models\JadwalKeberangkatan::with('paket.jenisPaket')
            ->when($jenisId, function ($q) use ($jenisId) {
                $q->whereHas('paket', function ($qq) use ($jenisId) {
                    $qq->where('jenis_id', $jenisId);
                });
            })
            ->get();

        return view('cicilan_jemaah.index', compact('cicilanJemaahs', 'jenisPakets', 'jenisId', 'jadwalKeberangkatans', 'jadwalId'));
    }

    public function create()
    {
        $jemaahs = \App\Models\Jemaah::with('pendaftaran.jadwalKeberangkatan.paket.jenisPaket')->get();

        return view('cicilan_jemaah.create', compact('jemaahs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cicilan' => 'required|array|min:1',
            'cicilan.*.jemaah_id' => 'required|exists:jemaah,id',
            'cicilan.*.nominal_cicilan' => 'required|integer|min:1',
            'cicilan.*.metode_bayar' => 'required|in:Transfer,Tunai',
            'cicilan.*.bukti_bayar' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        foreach ($request->cicilan as $index => $cicilanData) {
            $jemaah = \App\Models\Jemaah::findOrFail($cicilanData['jemaah_id']);
            $namaJemaah = strtolower(str_replace(' ', '', $jemaah->nama_jemaah));
            $tanggalBayar = now()->format('dmY');
            $cicilanKe = CicilanJemaah::where('jemaah_id', $cicilanData['jemaah_id'])->count() + 1;
            $kodeCicilan = 'cicilan' . $namaJemaah . $tanggalBayar . str_pad($cicilanKe, 3, '0', STR_PAD_LEFT);

            $buktiBayarPath = null;
            if ($request->hasFile("cicilan.{$index}.bukti_bayar")) {
                $file = $request->file("cicilan.{$index}.bukti_bayar");
                $buktiBayarPath = $file->store('bukti_bayar', 'public');
            }

            CicilanJemaah::create([
                'jemaah_id' => $cicilanData['jemaah_id'],
                'kode_cicilan' => $kodeCicilan,
                'nominal_cicilan' => $cicilanData['nominal_cicilan'],
                'tgl_bayar' => now(),
                'metode_bayar' => $cicilanData['metode_bayar'],
                'bukti_bayar' => $buktiBayarPath,
            ]);

            // Check if pendaftaran is fully paid
            $pendaftaran = $jemaah->pendaftaran;
            // Note: status_pembayaran column has been removed, so no update needed
        }

        return redirect()->route('cicilan-jemaah.index')->with('success', 'Cicilan Jemaah berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $cicilanJemaah = CicilanJemaah::with('jemaah.pendaftaran.jadwalKeberangkatan.paket.jenisPaket')->findOrFail($id);
        $jemaahs = \App\Models\Jemaah::with('pendaftaran.jadwalKeberangkatan.paket.jenisPaket')->get();

        return view('cicilan_jemaah.edit', compact('cicilanJemaah', 'jemaahs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jemaah_id' => 'required|exists:jemaah,id',
            'kode_cicilan' => 'required|string|max:50|unique:cicilan_jemaah,kode_cicilan,' . $id,
            'nominal_cicilan' => 'required|integer|min:1',
            'tgl_bayar' => 'required|date',
            'metode_bayar' => 'required|in:Transfer,Tunai',
            'bukti_bayar' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $cicilanJemaah = CicilanJemaah::findOrFail($id);

        $data = $request->only(['jemaah_id', 'kode_cicilan', 'nominal_cicilan', 'tgl_bayar', 'metode_bayar']);

        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $data['bukti_bayar'] = $file->store('bukti_bayar', 'public');
        }

        $cicilanJemaah->update($data);

        return redirect()->route('cicilan-jemaah.index')->with('success', 'Cicilan Jemaah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $cicilanJemaah = CicilanJemaah::findOrFail($id);
        $cicilanJemaah->delete();

        return redirect()->route('cicilan-jemaah.index')->with('success', 'Cicilan Jemaah berhasil dihapus.');
    }
}
