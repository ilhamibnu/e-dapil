<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kecamatan;

class KecamatanController extends Controller
{
    public function index(){
        $kecamatan = Kecamatan::all();
        return view('admin.pages.kecamatan',[
            'kecamatan' => $kecamatan,
        ]);
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required',
        ],[
            'name.required' => 'Nama Kecamatan tidak boleh kosong',
        ]);

        $kecamatan = new Kecamatan;
        $kecamatan->name = $request->name;
        $kecamatan->save();
        return redirect('/kecamatan')->with('create', 'Data Kecamatan berhasil ditambahkan');
    }

    public function update(Request $request, $id){

        $request->validate([
            'name' => 'required',
        ],[
            'name.required' => 'Nama Kecamatan tidak boleh kosong',
        ]);

        $kecamatan = Kecamatan::find($id);
        $kecamatan->name = $request->name;
        $kecamatan->save();
        return redirect('/kecamatan')->with('update', 'Data Kecamatan berhasil diubah');
    }

    public function delete($id){
        $kecamatan = Kecamatan::find($id);
        $kecamatan->delete();
        return redirect('/kecamatan')->with('delete', 'Data Kecamatan berhasil dihapus');
    }
}
