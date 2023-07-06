<?php

namespace App\Http\Controllers;

use App\Models\Relawan;
use Illuminate\Http\Request;


class RelawanController extends Controller
{
    public function index()
    {
        $relawan = Relawan::all();
        return view('admin.pages.relawan', [
            'relawan' => $relawan
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'alamat' => 'required'
        ], [
            'name.required' => 'Nama relawan harus diisi!',
            'alamat.required' => 'Alamat relawan harus diisi!'
        ]);

        Relawan::create([
            'name' => $request->name,
            'alamat' => $request->alamat
        ]);

        return redirect('/relawan')->with('success', 'Relawan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'alamat' => 'required'
        ], [
            'name.required' => 'Nama relawan harus diisi!',
            'alamat.required' => 'Alamat relawan harus diisi!'
        ]);

        $update = Relawan::find($id);
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
