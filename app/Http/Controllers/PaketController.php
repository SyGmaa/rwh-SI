<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\JenisPaket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index(Request $request)
    {
        $jenisId = $request->get('jenis_id');
        $query = Paket::with('jenisPaket');

        if ($jenisId) {
            $query->where('jenis_id', $jenisId);
        }

        $pakets = $query->get();
        $jenisPakets = JenisPaket::all();

        return view('paket.index', compact('pakets', 'jenisPakets', 'jenisId'));
    }

    public function create(Request $request)
    {
        $jenisId = $request->get('jenis_id');
        $jenisPakets = JenisPaket::all();

        return view('paket.create', compact('jenisPakets', 'jenisId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_id' => 'required|exists:jenis_paket,id',
            'nama_paket' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'jml_hari' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
        ]);

        Paket::create($request->all());

        return redirect()->route('paket.index', ['jenis_id' => $request->jenis_id])->with('success', 'Paket berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $paket = Paket::findOrFail($id);
        $jenisPakets = JenisPaket::all();

        return view('paket.edit', compact('paket', 'jenisPakets'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_id' => 'required|exists:jenis_paket,id',
            'nama_paket' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'jml_hari' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
        ]);

        $paket = Paket::findOrFail($id);
        $paket->update($request->all());

        return redirect()->route('paket.index', ['jenis_id' => $request->jenis_id])->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $paket = Paket::findOrFail($id);
        $jenisId = $paket->jenis_id;
        $paket->delete();

        return redirect()->route('paket.index', ['jenis_id' => $jenisId])->with('success', 'Paket berhasil dihapus.');
    }
}
