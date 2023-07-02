<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Caleg;
use App\Models\DetailTps;
use App\Models\Kecamatan;
use App\Models\DetailDesa;
use Illuminate\Http\Request;
use App\Models\DetailKecamatan;
use Illuminate\Support\Facades\DB;

class CalegController extends Controller
{

    // crud caleg


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

    // detail kecamatan

    public function detailkecamatan($id){
        $kecamatan = Kecamatan::all();
        $caleg = Caleg::find($id);

        $detailkecamatan = DB::table('tb_detail_kecamatan')
        ->join('tb_kecamatan', 'tb_detail_kecamatan.id_kecamatan', '=', 'tb_kecamatan.id')
        ->join('tb_caleg', 'tb_detail_kecamatan.id_caleg', '=', 'tb_caleg.id')
        ->select('tb_detail_kecamatan.*', 'tb_kecamatan.name as kecamatan', 'tb_caleg.name as caleg')
        ->where('tb_detail_kecamatan.id_caleg', '=', $id)
        ->get();

        return view('admin.pages.detail-kecamatan',[
            'caleg' => $caleg,
            'kecamatan' => $kecamatan,
            'detailkecamatan' => $detailkecamatan,
        ]);
    } 
    
    public function storedetailkecamatan(Request $request){
        $request->validate([
            'id_kecamatan' => 'required',
        ],[
            'id_kecamatan.required' => 'Kecamatan tidak boleh kosong',
        ]);

        $detailkecamatan = new DetailKecamatan;
        $detailkecamatan->id_kecamatan = $request->id_kecamatan;
        $detailkecamatan->id_caleg = $request->id_caleg;
        $detailkecamatan->save();
        return redirect()->back()->with('create', 'Data Detail Kecamatan berhasil ditambahkan');
    }

    public function updatedetailkecamatan(Request $request, $id){
        $request->validate([
            'id_kecamatan' => 'required',
        ],[
            'id_kecamatan.required' => 'Kecamatan tidak boleh kosong',
        ]);

        $detailkecamatan = DetailKecamatan::find($id);
        $detailkecamatan->id_kecamatan = $request->id_kecamatan;
        $detailkecamatan->id_caleg = $request->id_caleg;
        $detailkecamatan->save();
        return redirect()->back()->with('update', 'Data Detail Kecamatan berhasil diubah');
    }

    public function deletedetailkecamatan($id){
        $detailkecamatan = DetailKecamatan::find($id);
        $detailkecamatan->delete();
        return redirect()->back()->with('delete', 'Data Detail Kecamatan berhasil dihapus');
    }

    // detail desa

    public function detaildesa($id){

        $datakecamatan = DetailKecamatan::find($id);
        $id_caleg = $datakecamatan->id_caleg;
        $id_kecamatan = $datakecamatan->id_kecamatan;

        $caleg = Caleg::find($id_caleg);
        $desa = Desa::with('kecamatan')->where('id_kecamatan', $id_kecamatan)->get();

        $detaildesa = DB::table('tb_detail_desa')
        ->join('tb_desa', 'tb_detail_desa.id_desa', '=', 'tb_desa.id')
        ->join('tb_kecamatan', 'tb_desa.id_kecamatan', '=', 'tb_kecamatan.id')
        ->join('tb_caleg', 'tb_detail_desa.id_caleg', '=', 'tb_caleg.id')
        ->select('tb_detail_desa.*', 'tb_desa.name as desa', 'tb_caleg.name as caleg')
        ->where('tb_detail_desa.id_caleg', '=', $id_caleg)
        ->where('tb_desa.id_kecamatan', '=', $id_kecamatan)
        ->get();

        return view('admin.pages.detail-desa',[
            'caleg' => $caleg,
            'desa' => $desa,
            'detaildesa' => $detaildesa,
        ]);
    }

    public function storedetaildesa(Request $request){
        $request->validate([
            'id_desa' => 'required',
        ],[
            'id_desa.required' => 'Desa tidak boleh kosong',
        ]);

        $detaildesa = new DetailDesa;
        $detaildesa->id_desa = $request->id_desa;
        $detaildesa->id_caleg = $request->id_caleg;
        $detaildesa->save();
        return redirect()->back()->with('create', 'Data Detail Desa berhasil ditambahkan');
    }

    public function updatedetaildesa(Request $request, $id){
        $request->validate([
            'id_desa' => 'required',
        ],[
            'id_desa.required' => 'Desa tidak boleh kosong',
        ]);

        $detaildesa = DetailDesa::find($id);
        $detaildesa->id_desa = $request->id_desa;
        $detaildesa->id_caleg = $request->id_caleg;
        $detaildesa->save();
        return redirect()->back()->with('update', 'Data Detail Desa berhasil diubah');
    }

    public function deletedetaildesa($id){
        $detaildesa = DetailDesa::find($id);
        $detaildesa->delete();
        return redirect()->back()->with('delete', 'Data Detail Desa berhasil dihapus');
    }

    // detail tps

    public function detailtps($id){

        $datadesa = DetailDesa::find($id);
        $id_caleg = $datadesa->id_caleg;
        $id_desa = $datadesa->id;

        $caleg = Caleg::find($id_caleg);

        $detailtps = DB::table('tb_detail_tps')
        ->join('tb_detail_desa', 'tb_detail_tps.id_detail_desa', '=', 'tb_detail_desa.id')
        ->join('tb_caleg', 'tb_detail_tps.id_caleg', '=', 'tb_caleg.id')
        ->select('tb_detail_tps.*')
        ->where('tb_detail_tps.id_caleg', '=', $id_caleg)
        ->where('tb_detail_desa.id_desa', '=', $id_desa)
        ->get();

        return view('admin.pages.detail-tps',[
            'caleg' => $caleg,
            'datadesa' => $datadesa,
            'detailtps' => $detailtps,
        ]);
    }

    public function storedetailtps(Request $request){
        $request->validate([
           'name' => 'required',
        ],[
            'name.required' => 'Nama TPS tidak boleh kosong',
        ]);

        $detailtps = new DetailTps;
        $detailtps->name = $request->name;
        $detailtps->id_detail_desa = $request->id_detail_desa;
        $detailtps->id_caleg = $request->id_caleg;
        $detailtps->save();
        return redirect()->back()->with('create', 'Data Detail TPS berhasil ditambahkan');
    }

    public function updatedetailtps(Request $request, $id){
        $request->validate([
            'name' => 'required',
        ],[
            'name.required' => 'Nama TPS tidak boleh kosong',
        ]);

        $detailtps = DetailTps::find($id);
        $detailtps->name = $request->name;
        $detailtps->id_detail_desa = $request->id_detail_desa;
        $detailtps->id_caleg = $request->id_caleg;
        $detailtps->save();
        return redirect()->back()->with('update', 'Data Detail TPS berhasil diubah');
    }

    public function deletedetailtps($id){
        $detailtps = DetailTps::find($id);
        $detailtps->delete();
        return redirect()->back()->with('delete', 'Data Detail TPS berhasil dihapus');
    }
}
