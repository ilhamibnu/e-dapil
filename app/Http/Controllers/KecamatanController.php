<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\DetailKecamatan;
use Illuminate\Http\Request;
use App\Models\Kecamatan;

class KecamatanController extends Controller
{
    public function index()
    {
        $kecamatan = Kecamatan::all();
        return view('admin.pages.kecamatan', [
            'kecamatan' => $kecamatan,
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Nama Kecamatan tidak boleh kosong',
        ]);

        $kecamatan = new Kecamatan;
        $kecamatan->name = $request->name;
        $kecamatan->save();
        return redirect('/kecamatan')->with('create', 'Data Kecamatan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Nama Kecamatan tidak boleh kosong',
        ]);

        $kecamatan = Kecamatan::find($id);
        $kecamatan->name = $request->name;
        $kecamatan->save();
        return redirect('/kecamatan')->with('update', 'Data Kecamatan berhasil diubah');
    }

    public function delete($id)
    {

        // cek apakah kecamatan sudah terhubung detail kecamatan
        // cek apakah kecamatan sudah terhubung desa

        $detail_kecamatan = DetailKecamatan::where('id_kecamatan', $id)->first();
        $cekdesa = Desa::where('id_kecamatan', $id)->first();

        if ($detail_kecamatan) {
            return redirect('/kecamatan')->with('relasidetailkecamatan', 'Data Kecamatan tidak bisa dihapus karena sudah terhubung dengan data Desa');
        } elseif ($cekdesa) {
            return redirect('/kecamatan')->with('relasidesa', 'Data Kecamatan tidak bisa dihapus karena sudah terhubung dengan data Desa');
        } else {

            $kecamatan = Kecamatan::find($id);
            $kecamatan->delete();
            return redirect('/kecamatan')->with('delete', 'Data Kecamatan berhasil dihapus');
        }
    }
}
