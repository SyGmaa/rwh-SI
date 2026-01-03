<?php

namespace App\Http\Controllers;

use App\Models\JenisPaket;
use Illuminate\Http\Request;

class JenisPaketController extends Controller
{
    public function index()
    {
        $jenisPakets = JenisPaket::all();
        return view('jenis-paket.index', compact('jenisPakets'));
    }

    public function create()
    {
        return view('jenis-paket.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:100',
            'deskripsi' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        JenisPaket::create($request->all());

        return redirect()->route('jenis-paket.index')->with('success', 'Jenis Paket berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jenisPaket = JenisPaket::findOrFail($id);
        return view('jenis-paket.edit', compact('jenisPaket'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:100',
            'deskripsi' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $jenisPaket = JenisPaket::findOrFail($id);
        $jenisPaket->update($request->all());

        return redirect()->route('jenis-paket.index')->with('success', 'Jenis Paket berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jenisPaket = JenisPaket::findOrFail($id);
        $jenisPaket->delete();

        return redirect()->route('jenis-paket.index')->with('success', 'Jenis Paket berhasil dihapus.');
    }
}
