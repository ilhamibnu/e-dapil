<?php

namespace App\Http\Controllers;

use App\Models\Tps;
use App\Models\Relawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelawanController extends Controller
{
    public function index()
    {
        $relawan = DB::table('tb_relawan')
            ->join('tb_tps', 'tb_relawan.id_tps', '=', 'tb_tps.id')
            ->join('tb_desa', 'tb_tps.id_desa', '=', 'tb_desa.id')
            ->select('tb_relawan.*', 'tb_tps.name as tps', 'tb_desa.name as desa')
            ->get();
        $tps = Tps::with('desa')->get();
        return view('admin.pages.relawan', [
            'relawan' => $relawan,
            'id_tps' => $tps
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_tps' => 'required',
            'name' => 'required',
            'alamat' => 'required'
        ], [
            'id_tps.required' => 'Nama TPS harus diisi!',
            'name.required' => 'Nama relawan harus diisi!',
            'alamat.required' => 'Alamat relawan harus diisi!'
        ]);

        Relawan::create([
            'id_tps' => $request->id_tps,
            'name' => $request->name,
            'alamat' => $request->alamat
        ]);

        return redirect('/relawan')->with('success', 'Relawan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_tps' => 'required',
            'name' => 'required',
            'alamat' => 'required'
        ], [
            'name.required' => 'Nama relawan harus diisi!',
            'alamat.required' => 'Alamat relawan harus diisi!',
            'id_tps.required' => 'Nama TPS harus diisi!',
        ]);

        $update = Relawan::find($id);
        $update->id_tps = $request->id_tps;
        $update->name = $request->name;
        $update->alamat = $request->alamat;
        $update->save();

        return redirect('/relawan')->with('success', 'Relawan berhasil diubah!');
    }

    public function destroy($id)
    {
        Relawan::find($id)->delete();
        return redirect('/relawan')->with('success', 'Relawan berhasil dihapus!');
    }
}
