<?php

namespace App\Http\Controllers;

use App\Models\Tps;
use App\Models\Desa;
use Illuminate\Http\Request;


class TpsController extends Controller
{
    public function index()
    {
        $desa = Desa::all();
        $tps = Tps::with('desa')->get();
        return view('admin.pages.tps', [
            'tps' => $tps,
            'desa' => $desa,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'id_desa' => 'required',
        ], [
            'name.required' => 'Nama TPS harus diisi!',
        ]);

        Tps::create([
            'id_desa' => $request->id_desa,
            'name' => $request->name,
        ]);

        return redirect('/tps')->with('create', 'TPS berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'id_desa' => 'required',
        ], [
            'name.required' => 'Nama TPS harus diisi!',
        ]);

        $update = Tps::find($id);
        $update->id_desa = $request->id_desa;
        $update->name = $request->name;
        $update->save();

        return redirect('/tps')->with('update', 'TPS berhasil diubah!');
    }

    public function destroy($id)
    {
        Tps::find($id)->delete();
        return redirect('/tps')->with('delete', 'TPS berhasil dihapus!');
    }
}
