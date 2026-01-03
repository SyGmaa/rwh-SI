<?php

namespace App\Http\Controllers;

use App\Models\JenisDokumen;
use App\Models\Jemaah;
use Illuminate\Http\Request;

class JenisDokumenController extends Controller
{
    public function index()
    {
        $jenisDokumens = JenisDokumen::all();
        return view('jenis-dokumen.index', compact('jenisDokumens'));
    }

    public function create()
    {
        return view('jenis-dokumen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:100',
            'deskripsi' => 'nullable|string|max:255',
            'wajib_upload' => 'required|boolean',
            'is_active' => 'required|boolean',
        ]);

        JenisDokumen::create($request->all());

        return redirect()->route('jenis-dokumen.index')->with('success', 'Jenis Dokumen berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jenisDokumen = JenisDokumen::findOrFail($id);
        return view('jenis-dokumen.edit', compact('jenisDokumen'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:100',
            'deskripsi' => 'nullable|string|max:255',
            'wajib_upload' => 'required|boolean',
            'is_active' => 'required|boolean',
        ]);

        $jenisDokumen = JenisDokumen::findOrFail($id);
        $oldIsActive = $jenisDokumen->is_active;
        $jenisDokumen->update($request->all());

        // If is_active changed, update status_berkas for all jemaah
        if ($oldIsActive != $request->is_active) {
            $this->updateStatusBerkasForAllJemaah();
        }

        return redirect()->route('jenis-dokumen.index')->with('success', 'Jenis Dokumen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jenisDokumen = JenisDokumen::findOrFail($id);
        $jenisDokumen->delete();

        return redirect()->route('jenis-dokumen.index')->with('success', 'Jenis Dokumen berhasil dihapus.');
    }

    private function updateStatusBerkasForAllJemaah()
    {
        $jemaahs = Jemaah::with('dokumenJemaah.jenisDokumen')->get();

        foreach ($jemaahs as $jemaah) {
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
}
