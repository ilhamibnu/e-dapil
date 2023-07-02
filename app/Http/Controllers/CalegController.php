<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caleg;

class CalegController extends Controller
{
    public function index(){
        $caleg = Caleg::all();
        return view('admin.pages.caleg',[
            'caleg' => $caleg,
        ]);
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required',
        ],[
            'name.required' => 'Nama Caleg tidak boleh kosong',

        ]);

        $caleg = new Caleg;
        $caleg->name = $request->name;
        $caleg->save();
        return redirect('/caleg')->with('create', 'Data Caleg berhasil ditambahkan');

    }

    public function update(Request $request, $id){

        $request->validate([
            'name' => 'required',
        ],[
            'name.required' => 'Nama Caleg tidak boleh kosong',
        ]);

        $caleg = Caleg::find($id);
        $caleg->name = $request->name;
        $caleg->save();
        return redirect('/caleg')->with('update', 'Data Caleg berhasil diubah');
    }

    public function delete($id){
        $caleg = Caleg::find($id);
        $caleg->delete();
        return redirect('/caleg')->with('delete', 'Data Caleg berhasil dihapus');
    }
}
