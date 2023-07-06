<?php

namespace App\Http\Controllers;

use App\Models\Tps;
use Illuminate\Http\Request;


class TpsController extends Controller
{
    public function index()
    {
        $tps = Tps::all();
        return view('admin.pages.tps', [
            'tps' => $tps
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Nama TPS harus diisi!',
        ]);

        Tps::create([
            'name' => $request->name,
        ]);

        return redirect('/tps')->with('create', 'TPS berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Nama TPS harus diisi!',
        ]);

        $update = Tps::find($id);
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
