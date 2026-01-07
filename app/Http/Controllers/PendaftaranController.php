<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\JadwalKeberangkatan;
use App\Models\JenisPaket;
use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $jenisId = $request->get('jenis_id');
        $query = Pendaftaran::with('jadwalKeberangkatan.paket.jenisPaket');

        if ($jenisId) {
            $query->whereHas('jadwalKeberangkatan.paket', function ($q) use ($jenisId) {
                $q->where('jenis_id', $jenisId);
            });
        }

        $pendaftarans = $query->get();
        $jenisPakets = JenisPaket::where('is_active', '1')->get();

        return view('pendaftaran.index', compact('pendaftarans', 'jenisPakets', 'jenisId'));
    }

    public function create()
    {
        $jenisId = request('jenis_id');
        $query = JadwalKeberangkatan::with('paket.jenisPaket')->where('status', 'Tersedia');

        if ($jenisId) {
            $query->whereHas('paket', function ($q) use ($jenisId) {
                $q->where('jenis_id', $jenisId);
            });
        }

        $jadwalKeberangkatans = $query->get();

        return view('pendaftaran.create', compact('jadwalKeberangkatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_keberangkatan,id',
            'nama_pendaftar' => 'required|array|min:1',
            'nama_pendaftar.*' => 'required|string|max:255',
            'no_tlp' => 'nullable|array',
            'no_tlp.*' => 'nullable|string|max:20',
            'option' => 'required|in:2,3,4',
            'dp' => 'required|integer|min:0',
            'metode_bayar' => 'required|in:Transfer,Tunai',
            'bukti_bayar' => 'nullable|string|max:255',
        ]);

        $jadwal = JadwalKeberangkatan::findOrFail($request->jadwal_id);
        $jumlahPendaftar = count($request->nama_pendaftar);

        // Check if sufficient kuota
        if ($jadwal->kuota < $jumlahPendaftar) {
            return redirect()->back()->withErrors(['jadwal_id' => 'Kuota tidak mencukupi untuk jumlah pendaftar.'])->withInput();
        }

        // Create pendaftaran with first person's data
        $pendaftaran = Pendaftaran::create([
            'jadwal_id' => $request->jadwal_id,
            'nama_pendaftar' => $request->nama_pendaftar[0],
            'no_tlp' => $request->no_tlp[0] ?? null,
            'dp' => $request->dp,
            'metode_bayar' => $request->metode_bayar,
            'bukti_bayar' => $request->bukti_bayar,
        ]);

        // Calculate biaya_tambahan based on pax
        $biayaTambahan = 0;
        if ($request->option == 3) {
            $biayaTambahan = 1000000; // 1 juta for 3 pax
        } elseif ($request->option == 2) {
            $biayaTambahan = 2000000; // 2 juta for 2 pax
        }

        // Create jemaah records for all persons
        foreach ($request->nama_pendaftar as $index => $nama) {
            \App\Models\Jemaah::create([
                'pendaftaran_id' => $pendaftaran->id,
                'nama_jemaah' => $nama,
                'no_tlp' => $request->no_tlp[$index] ?? null,
                'pax' => $request->option,
                'biaya_tambahan' => $biayaTambahan,
            ]);
        }

        // Decrement kuota
        $jadwal->kuota -= $jumlahPendaftar;
        if ($jadwal->kuota <= 0) {
            $jadwal->status = 'Penuh';
        }
        $jadwal->save();

        // Send Notification to all users (admins)
        $users = User::all();
        $message = "Pendaftaran baru: " . $pendaftaran->nama_pendaftar . " untuk paket " . $jadwal->paket->nama_paket;
        $url = route('pendaftaran.show', $pendaftaran->id);
        Notification::send($users, new SystemNotification($message, $url));

        // Check for Low Quota Alert
        if ($jadwal->kuota > 0 && $jadwal->kuota < 5) {
            $quotaMessage = "PERINGATAN: Sisa kuota untuk paket " . $jadwal->paket->nama_paket . " sisa " . $jadwal->kuota . " slot!";
            Notification::send($users, new SystemNotification($quotaMessage, $url));
        }

        return redirect()->route('pendaftaran.index')->with('success', 'Pendaftaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pendaftaran = Pendaftaran::with('jadwalKeberangkatan.paket.jenisPaket')->findOrFail($id);
        $jadwalKeberangkatans = JadwalKeberangkatan::with('paket.jenisPaket')->where('status', 'Tersedia')->get();

        return view('pendaftaran.edit', compact('pendaftaran', 'jadwalKeberangkatans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_keberangkatan,id',
            'nama_pendaftar' => 'required|string|max:255',
            'no_tlp' => 'nullable|string|max:20',
            'dp' => 'required|integer|min:0',
            'metode_bayar' => 'required|in:Transfer,Tunai',
            'bukti_bayar' => 'nullable|string|max:255',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $oldJadwalId = $pendaftaran->jadwal_id;
        $newJadwalId = $request->jadwal_id;

        if ($oldJadwalId != $newJadwalId) {
            $oldJadwal = JadwalKeberangkatan::findOrFail($oldJadwalId);
            $newJadwal = JadwalKeberangkatan::findOrFail($newJadwalId);
            $jumlahJemaah = $pendaftaran->jemaahs()->count();

            // Check if new jadwal has sufficient kuota
            if ($newJadwal->kuota < $jumlahJemaah) {
                return redirect()->back()->withErrors(['jadwal_id' => 'Kuota tidak mencukupi untuk jumlah jemaah.'])->withInput();
            }

            // Adjust kuota for old jadwal
            $oldJadwal->kuota += $jumlahJemaah;
            if ($oldJadwal->kuota > 0 && $oldJadwal->status == 'Penuh') {
                $oldJadwal->status = 'Tersedia';
            }
            $oldJadwal->save();

            // Adjust kuota for new jadwal
            $newJadwal->kuota -= $jumlahJemaah;
            if ($newJadwal->kuota <= 0) {
                $newJadwal->status = 'Penuh';
            }
            $newJadwal->save();
        }

        $pendaftaran->update($request->all());

        return redirect()->route('pendaftaran.index')->with('success', 'Pendaftaran berhasil diperbarui.');
    }

    public function show($id)
    {
        $pendaftaran = Pendaftaran::with([
            'jadwalKeberangkatan.paket.jenisPaket',
            'jemaahs.cicilans',
            'jemaahs.dokumenJemaah.jenisDokumen'
        ])->findOrFail($id);

        return view('pendaftaran.show', compact('pendaftaran'));
    }

    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $jadwal = $pendaftaran->jadwalKeberangkatan;
        $jumlahJemaah = $pendaftaran->jemaahs()->count();

        $pendaftaran->delete();

        // Increment kuota
        $jadwal->kuota += $jumlahJemaah;
        if ($jadwal->kuota > 0 && $jadwal->status == 'Penuh') {
            $jadwal->status = 'Tersedia';
        }
        $jadwal->save();

        return redirect()->route('pendaftaran.index')->with('success', 'Pendaftaran berhasil dihapus.');
    }
}
