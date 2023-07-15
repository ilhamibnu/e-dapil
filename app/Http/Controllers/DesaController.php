<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Desa;
use App\Models\DetailDesa;
use App\Models\Kecamatan;
use App\Models\Tps;

class DesaController extends Controller
{
    public function index()
    {
        $kecamatan = Kecamatan::all();
        $desa = Desa::with('kecamatan')->get();
        return view('admin.pages.desa', [
            'kecamatan' => $kecamatan,
            'desa' => $desa,
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'id_kecamatan' => 'required',
        ], [
            'name.required' => 'Nama Desa tidak boleh kosong',
            'id_kecamatan.required' => 'Kecamatan tidak boleh kosong',
        ]);

        $desa = new Desa;
        $desa->name = $request->name;
        $desa->id_kecamatan = $request->id_kecamatan;
        $desa->save();
        return redirect('/desa')->with('create', 'Data Desa berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'id_kecamatan' => 'required',
        ], [
            'name.required' => 'Nama Desa tidak boleh kosong',
            'id_kecamatan.required' => 'Kecamatan tidak boleh kosong',
        ]);

        $desa = Desa::find($id);
        $desa->name = $request->name;
        $desa->id_kecamatan = $request->id_kecamatan;
        $desa->save();
        return redirect('/desa')->with('update', 'Data Desa berhasil diubah');
    }

    public function delete($id)
    {
        // cek apakah desa sudah terhubung detail desa

        $detail_desa = DetailDesa::where('id_desa', $id)->first();
        $cektps = Tps::where('id_desa', $id)->first();

        if ($detail_desa) {
            return redirect('/desa')->with('relasidetaildesa', 'Data Desa tidak bisa dihapus karena sudah terhubung dengan data TPS');
        } elseif ($cektps) {
            return redirect('/desa')->with('relasitps', 'Data Desa tidak bisa dihapus karena sudah terhubung dengan data TPS');
        } else {

            $desa = Desa::find($id);
            $desa->delete();
            return redirect('/desa')->with('delete', 'Data Desa berhasil dihapus');
        }
    }
}
