<?php

namespace App\Http\Controllers;

use App\Models\DokumenJemaah;
use App\Models\Jemaah;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenJemaahController extends Controller
{
    public function index(Request $request)
    {
        $jadwalId = $request->get('jadwal_id');
        $jenisId = $request->get('jenis_id');
        $query = Jemaah::with('pendaftaran.jadwalKeberangkatan.paket.jenisPaket', 'dokumenJemaah.jenisDokumen');

        if ($jadwalId) {
            $query->whereHas('pendaftaran', function ($q) use ($jadwalId) {
                $q->where('jadwal_id', $jadwalId);
            });
        }

        if ($jenisId) {
            $query->whereHas('pendaftaran.jadwalKeberangkatan.paket', function ($q) use ($jenisId) {
                $q->where('jenis_id', $jenisId);
            });
        }

        $jemaahs = $query->get();
        $jadwalKeberangkatans = \App\Models\JadwalKeberangkatan::with('paket.jenisPaket')
            ->when($jenisId, function ($q) use ($jenisId) {
                $q->whereHas('paket', function ($qq) use ($jenisId) {
                    $qq->where('jenis_id', $jenisId);
                });
            })
            ->get();
        $jenisPakets = \App\Models\JenisPaket::all();

        return view('dokumen_jemaah.index', compact('jemaahs', 'jadwalKeberangkatans', 'jadwalId', 'jenisPakets', 'jenisId'));
    }

    public function create()
    {
        $jemaahs = Jemaah::with('pendaftaran.jadwalKeberangkatan.paket.jenisPaket')->get();
        $jenisDokumens = JenisDokumen::where('is_active', 1)->get();

        $jemaahId = request('jemaah_id');
        if ($jemaahId) {
            $uploadedJenisIds = DokumenJemaah::where('jemaah_id', $jemaahId)->pluck('jenis_id')->toArray();
            $jenisDokumens = $jenisDokumens->whereNotIn('id', $uploadedJenisIds);
        }

        return view('dokumen_jemaah.create', compact('jemaahs', 'jenisDokumens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jemaah_id' => 'required|array|min:1',
            'jemaah_id.*' => 'required|exists:jemaah,id',
            'jenis_id' => 'required|array|min:1',
            'jenis_id.*' => 'required|exists:jenis_dokumen,id',
            'file_path' => 'required|array|min:1',
            'file_path.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $jemaahIds = $request->jemaah_id;
        $jenisIds = $request->jenis_id;
        $files = $request->file('file_path');

        $count = count($jemaahIds);
        $uniqueJemaahIds = [];

        for ($i = 0; $i < $count; $i++) {
            $jemaahId = $jemaahIds[$i];
            $jenisId = $jenisIds[$i];
            $file = $files[$i];

            // Check for duplicate jenis for same jemaah
            $existing = DokumenJemaah::where('jemaah_id', $jemaahId)->where('jenis_id', $jenisId)->exists();
            if ($existing) {
                continue; // Skip if already exists
            }

            // Get jemaah and jenis for filename
            $jemaah = Jemaah::find($jemaahId);
            $jenis = JenisDokumen::find($jenisId);

            // Create custom filename: jenis_dokumen + nama_jemaah
            $filename = $jenis->nama_jenis . $jemaah->nama_jemaah . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('dokumen_jemaah', $filename, 'public');

            DokumenJemaah::create([
                'jemaah_id' => $jemaahId,
                'jenis_id' => $jenisId,
                'file_path' => $filePath,
                'tanggal_upload' => now(),
            ]);

            if (!in_array($jemaahId, $uniqueJemaahIds)) {
                $uniqueJemaahIds[] = $jemaahId;
            }
        }

        // Update status_berkas for each unique jemaah
        foreach ($uniqueJemaahIds as $jemaahId) {
            $this->updateStatusBerkas($jemaahId);
        }

        return redirect()->route('dokumen-jemaah.index')->with('success', 'Dokumen Jemaah berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $dokumenJemaah = DokumenJemaah::with('jemaah.pendaftaran.jadwalKeberangkatan.paket.jenisPaket', 'jenisDokumen')->findOrFail($id);
        $jemaahs = Jemaah::with('pendaftaran.jadwalKeberangkatan.paket.jenisPaket')->get();
        $jenisDokumens = JenisDokumen::where('is_active', 1)->get();

        // Exclude already uploaded jenis_dokumen for this jemaah, except the current one
        $uploadedJenisIds = DokumenJemaah::where('jemaah_id', $dokumenJemaah->jemaah_id)
            ->where('id', '!=', $id)
            ->pluck('jenis_id')
            ->toArray();
        $jenisDokumens = $jenisDokumens->whereNotIn('id', $uploadedJenisIds);

        return view('dokumen_jemaah.edit', compact('dokumenJemaah', 'jemaahs', 'jenisDokumens'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jemaah_id' => 'required|exists:jemaah,id',
            'jenis_id' => 'required|exists:jenis_dokumen,id',
            'file_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $dokumenJemaah = DokumenJemaah::findOrFail($id);

        $data = [
            'jemaah_id' => $request->jemaah_id,
            'jenis_id' => $request->jenis_id,
        ];

        if ($request->hasFile('file_path')) {
            // Delete old file
            if ($dokumenJemaah->file_path && Storage::disk('public')->exists($dokumenJemaah->file_path)) {
                Storage::disk('public')->delete($dokumenJemaah->file_path);
            }

            // Get jemaah and jenis for filename
            $jemaah = Jemaah::find($request->jemaah_id);
            $jenis = JenisDokumen::find($request->jenis_id);

            // Create custom filename: jenis_dokumen + nama_jemaah
            $filename = $jenis->nama_jenis . $jemaah->nama_jemaah . '.' . $request->file('file_path')->getClientOriginalExtension();
            $data['file_path'] = $request->file('file_path')->storeAs('dokumen_jemaah', $filename, 'public');
            $data['tanggal_upload'] = now();
        }

        $dokumenJemaah->update($data);

        // Check and update status_berkas
        $this->updateStatusBerkas($request->jemaah_id);

        return redirect()->route('dokumen-jemaah.index')->with('success', 'Dokumen Jemaah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $dokumenJemaah = DokumenJemaah::findOrFail($id);

        // Delete file
        if ($dokumenJemaah->file_path && Storage::disk('public')->exists($dokumenJemaah->file_path)) {
            Storage::disk('public')->delete($dokumenJemaah->file_path);
        }

        $dokumenJemaah->delete();

        // Check and update status_berkas
        $this->updateStatusBerkas($dokumenJemaah->jemaah_id);

        return redirect()->route('dokumen-jemaah.index')->with('success', 'Dokumen Jemaah berhasil dihapus.');
    }

    private function updateStatusBerkas($jemaahId)
    {
        $jemaah = Jemaah::with('dokumenJemaah.jenisDokumen')->find($jemaahId);

        if (!$jemaah) {
            return;
        }

        // Get all active document types
        $activeDokumen = JenisDokumen::where('is_active', 1)->pluck('id')->toArray();

        // Get uploaded documents for this jemaah
        $uploadedDokumen = $jemaah->dokumenJemaah->pluck('jenis_id')->toArray();

        // Check if all active documents are uploaded
        $allActiveUploaded = empty(array_diff($activeDokumen, $uploadedDokumen));

        // Update status_berkas
        $jemaah->update([
            'status_berkas' => $allActiveUploaded ? 'Lengkap' : 'Belum Lengkap'
        ]);
    }
}
