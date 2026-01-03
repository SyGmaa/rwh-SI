<?php

namespace App\Http\Controllers;

use App\Models\Jemaah;
use App\Models\JenisPaket;
use Illuminate\Http\Request;

class JemaahController extends Controller
{
    public function index(Request $request)
    {
        $jenisId = $request->get('jenis_id');
        $jadwalId = $request->get('jadwal_id');
        $query = Jemaah::with('pendaftaran.jadwalKeberangkatan.paket.jenisPaket');

        if ($jenisId) {
            $query->whereHas('pendaftaran.jadwalKeberangkatan.paket', function ($q) use ($jenisId) {
                $q->where('jenis_id', $jenisId);
            });
        }

        if ($jadwalId) {
            $query->whereHas('pendaftaran', function ($q) use ($jadwalId) {
                $q->where('jadwal_id', $jadwalId);
            });
        }

        $jemaahs = $query->get();
        $jenisPakets = JenisPaket::all();
        $jadwalKeberangkatans = \App\Models\JadwalKeberangkatan::with('paket.jenisPaket')->get();

        return view('jemaah.index', compact('jemaahs', 'jenisPakets', 'jadwalKeberangkatans', 'jenisId', 'jadwalId'));
    }

    public function create()
    {
        $pendaftarans = \App\Models\Pendaftaran::with('jadwalKeberangkatan.paket.jenisPaket')->get();
        $jadwalKeberangkatans = \App\Models\JadwalKeberangkatan::with('paket.jenisPaket')->get();

        return view('jemaah.create', compact('pendaftarans', 'jadwalKeberangkatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftaran,id',
            'nama_jemaah' => 'required|string|max:255',
            'no_tlp' => 'nullable|string|max:20',
            'jadwal_override_id' => 'nullable|exists:jadwal_keberangkatan,id',
            'status_berkas' => 'required|in:Lengkap,Belum Lengkap',
            'option' => 'required|in:2,3,4',
            'biaya_tambahan' => 'required|integer|min:0',
            'status_pembayaran' => 'required|in:Belum Lunas,Lunas,Dibatalkan',
        ]);

        // Calculate biaya_tambahan based on pax
        $biayaTambahan = 0;
        if ($request->option == 3) {
            $biayaTambahan = 1000000; // 1 juta for 3 pax
        } elseif ($request->option == 2) {
            $biayaTambahan = 2000000; // 2 juta for 2 pax
        }

        Jemaah::create(array_merge($request->all(), [
            'pax' => $request->option,
            'biaya_tambahan' => $biayaTambahan,
        ]));

        return redirect()->route('jemaah.index')->with('success', 'Jemaah berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jemaah = Jemaah::with('pendaftaran.jadwalKeberangkatan.paket.jenisPaket')->findOrFail($id);
        $pendaftarans = \App\Models\Pendaftaran::with('jadwalKeberangkatan.paket.jenisPaket')->get();
        $jadwalKeberangkatans = \App\Models\JadwalKeberangkatan::with('paket.jenisPaket')->get();

        return view('jemaah.edit', compact('jemaah', 'pendaftarans', 'jadwalKeberangkatans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftaran,id',
            'nama_jemaah' => 'required|string|max:255',
            'no_tlp' => 'nullable|string|max:20',
            'jadwal_override_id' => 'nullable|exists:jadwal_keberangkatan,id',
            'status_berkas' => 'required|in:Lengkap,Belum Lengkap',
            'option' => 'required|in:2,3,4',
            'biaya_tambahan' => 'required|integer|min:0',
            'status_pembayaran' => 'required|in:Belum Lunas,Lunas,Dibatalkan',
        ]);

        // Calculate biaya_tambahan based on pax
        $biayaTambahan = 0;
        if ($request->option == 3) {
            $biayaTambahan = 1000000; // 1 juta for 3 pax
        } elseif ($request->option == 2) {
            $biayaTambahan = 2000000; // 2 juta for 2 pax
        }

        $jemaah = Jemaah::findOrFail($id);
        $oldStatus = $jemaah->status_pembayaran;
        $newStatus = $request->status_pembayaran;
        $oldJadwalOverrideId = $jemaah->jadwal_override_id;
        $newJadwalOverrideId = $request->jadwal_override_id;

        $jemaah->update(array_merge($request->all(), [
            'pax' => $request->option,
            'biaya_tambahan' => $biayaTambahan,
        ]));

        // Adjust kuota based on status_pembayaran change
        if ($oldStatus != $newStatus) {
            $jadwal = $jemaah->jadwal_override_id ? $jemaah->jadwalOverride : $jemaah->pendaftaran->jadwalKeberangkatan;

            if ($newStatus == 'Dibatalkan' && $oldStatus != 'Dibatalkan') {
                // Status changed to Dibatalkan, increment kuota
                $jadwal->kuota += 1;
                if ($jadwal->kuota > 0 && $jadwal->status == 'Penuh') {
                    $jadwal->status = 'Tersedia';
                }
            } elseif ($oldStatus == 'Dibatalkan' && $newStatus != 'Dibatalkan') {
                // Status changed from Dibatalkan to something else, decrement kuota
                $jadwal->kuota -= 1;
                if ($jadwal->kuota <= 0) {
                    $jadwal->status = 'Penuh';
                }
            }
            $jadwal->save();
        }

        // Adjust kuota based on jadwal_override_id change
        if ($oldJadwalOverrideId != $newJadwalOverrideId && $newStatus != 'Dibatalkan') {
            $jadwalPendaftaran = $jemaah->pendaftaran->jadwalKeberangkatan;
            $jadwalSebelum = $oldJadwalOverrideId ? \App\Models\JadwalKeberangkatan::find($oldJadwalOverrideId) : $jadwalPendaftaran;
            $jadwalSekarang = $newJadwalOverrideId ? \App\Models\JadwalKeberangkatan::find($newJadwalOverrideId) : $jadwalPendaftaran;

            if ($jadwalSebelum && $jadwalSekarang && $jadwalSebelum->id != $jadwalSekarang->id) {
                // Increment kuota for previous jadwal
                $jadwalSebelum->kuota += 1;
                if ($jadwalSebelum->kuota > 0 && $jadwalSebelum->status == 'Penuh') {
                    $jadwalSebelum->status = 'Tersedia';
                }
                $jadwalSebelum->save();

                // Decrement kuota for new jadwal
                $jadwalSekarang->kuota -= 1;
                if ($jadwalSekarang->kuota <= 0) {
                    $jadwalSekarang->status = 'Penuh';
                }
                $jadwalSekarang->save();
            }
        }

        return redirect()->route('jemaah.index')->with('success', 'Jemaah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jemaah = Jemaah::findOrFail($id);
        $jadwal = $jemaah->jadwal_override_id ? $jemaah->jadwalOverride : $jemaah->pendaftaran->jadwalKeberangkatan;

        $jemaah->delete();

        // Increment kuota
        $jadwal->kuota += 1;
        if ($jadwal->kuota > 0 && $jadwal->status == 'Penuh') {
            $jadwal->status = 'Tersedia';
        }
        $jadwal->save();

        return redirect()->route('jemaah.index')->with('success', 'Jemaah berhasil dihapus.');
    }

    public function show($id)
    {
        $jemaah = Jemaah::with([
            'pendaftaran.jadwalKeberangkatan.paket.jenisPaket',
            'jadwalOverride.paket.jenisPaket',
            'cicilans',
            'dokumenJemaah.jenisDokumen'
        ])->findOrFail($id);

        return view('jemaah.show', compact('jemaah'));
    }
}
