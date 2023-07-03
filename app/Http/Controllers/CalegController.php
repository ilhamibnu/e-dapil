<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Caleg;
use App\Models\DetailTps;
use App\Models\Kecamatan;
use App\Models\DetailDesa;
use Illuminate\Http\Request;
use App\Models\DetailPemilih;
use App\Models\DetailRelawan;
use App\Models\DetailKecamatan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CalegController extends Controller
{

    // crud caleg


    public function index(){
        $caleg = Caleg::all()->sortBy('no_urut');
        return view('admin.pages.caleg',[
            'caleg' => $caleg,
        ]);
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required',
            'no_urut' => 'required',
            'foto' => 'required|max:5000|mimes:jpg,jpeg,png',
        ],[
            'name.required' => 'Nama Caleg tidak boleh kosong',
            'no_urut.required' => 'No Urut tidak boleh kosong',
            'foto.required' => 'Foto tidak boleh kosong',
            'foto.max' => 'Foto maksimal 5MB',
            'foto.mimes' => 'Foto harus berformat jpg, jpeg, png',
        ]);

        $fileNameImage = time() . Rand(999, 999) . '.' . $request->foto->extension();
        $request->foto->move(public_path('admin/foto/caleg/'), $fileNameImage);

        $caleg = new Caleg;
        $caleg->name = $request->name;
        $caleg->no_urut = $request->no_urut;
        $caleg->foto = $fileNameImage;
        $caleg->save();
        return redirect('/caleg')->with('create', 'Data Caleg berhasil ditambahkan');

    }

    public function update(Request $request, $id){

        $request->validate([
            'name' => 'required',
            'no_urut' => 'required',
            'foto' => 'max:5000|mimes:jpg,jpeg,png',
        ],[
            'name.required' => 'Nama Caleg tidak boleh kosong',
            'no_urut.required' => 'No Urut tidak boleh kosong',
            'foto.max' => 'Foto maksimal 5MB',
            'foto.mimes' => 'Foto harus berformat jpg, jpeg, png',
        ]);

        if($request->foto){
            $caleg = Caleg::find($id);
            File::delete('admin/foto/caleg/' . $caleg->foto);

            $fileNameImage = time() . Rand(999, 999) . '.' . $request->foto->extension();
            $request->foto->move(public_path('admin/foto/caleg/'), $fileNameImage);

            $caleg->foto = $fileNameImage;
            $caleg->save();
        }

        $caleg = Caleg::find($id);
        $caleg->name = $request->name;
        $caleg->no_urut = $request->no_urut;
        $caleg->save();
        return redirect('/caleg')->with('update', 'Data Caleg berhasil diubah');
    }

    public function delete($id){
        $caleg = Caleg::find($id);
        File::delete('admin/foto/caleg/' . $caleg->foto);
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
        ->where('tb_detail_tps.id_detail_desa', '=', $id_desa)
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

    // detail relawatan

    public function detailrelawan($id){

        $datatps = DetailTps::find($id);
        $id_caleg = $datatps->id_caleg;
        $id_tps = $datatps->id;

        $caleg = Caleg::find($id_caleg);


            $detailrelawan = DB::table('tb_detail_relawan')
            ->join('tb_detail_tps', 'tb_detail_relawan.id_detail_tps', '=', 'tb_detail_tps.id')
            ->join('tb_caleg', 'tb_detail_relawan.id_caleg', '=', 'tb_caleg.id')
            ->select('tb_detail_relawan.*')
            ->where('tb_detail_relawan.id_caleg', '=', $id_caleg)
            ->where('tb_detail_relawan.id_detail_tps', '=', $id_tps)
            ->get();
        return view('admin.pages.detail-relawan',[
            'caleg' => $caleg,
            'datatps' => $datatps,
            'detailrelawan' => $detailrelawan,
            
        ]);
    }

    public function storedetailrelawan(Request $request){
        $request->validate([
           'name' => 'required',
           'alamat' => 'required',
        ],[
            'name.required' => 'Nama Relawan tidak boleh kosong',
            'alamat.required' => 'Alamat Relawan tidak boleh kosong',
        ]);

        $detailrelawan = new DetailRelawan;
        $detailrelawan->name = $request->name;
        $detailrelawan->alamat = $request->alamat;
        $detailrelawan->id_detail_tps = $request->id_detail_tps;
        $detailrelawan->id_caleg = $request->id_caleg;
        $detailrelawan->save();



        return redirect()->back()->with('create', 'Data Detail Relawan berhasil ditambahkan');
    }

    public function updatedetailrelawan(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'alamat' => 'required',
        ],[
            'name.required' => 'Nama Relawan tidak boleh kosong',
            'alamat.required' => 'Alamat Relawan tidak boleh kosong',
        ]);

        $detailrelawan = DetailRelawan::find($id);
        $detailrelawan->name = $request->name;
        $detailrelawan->alamat = $request->alamat;
        $detailrelawan->id_detail_tps = $request->id_detail_tps;
        $detailrelawan->id_caleg = $request->id_caleg;
        $detailrelawan->save();
        return redirect()->back()->with('update', 'Data Detail Relawan berhasil diubah');
    }

    public function deletedetailrelawan($id){
        $detailrelawan = DetailRelawan::find($id);
        $detailrelawan->delete();
        return redirect()->back()->with('delete', 'Data Detail Relawan berhasil dihapus');
    }

    // detail pemilih

    public function detailpemilih($id){

        $datarelawan = DetailRelawan::find($id);
        $id_caleg = $datarelawan->id_caleg;
        $id_relawan = $datarelawan->id;

        $caleg = Caleg::find($id_caleg);

        $detailpemilih = DB::table('tb_detail_pemilih')
        ->join('tb_detail_relawan', 'tb_detail_pemilih.id_detail_relawan', '=', 'tb_detail_relawan.id')
        ->join('tb_caleg', 'tb_detail_pemilih.id_caleg', '=', 'tb_caleg.id')
        ->select('tb_detail_pemilih.*')
        ->where('tb_detail_pemilih.id_caleg', '=', $id_caleg)
        ->where('tb_detail_pemilih.id_detail_relawan', '=', $id_relawan)
        ->get();

        return view('admin.pages.detail-pemilih',[
            'caleg' => $caleg,
            'datarelawan' => $datarelawan,
            'detailpemilih' => $detailpemilih,
        ]);
    }

    public function storedetailpemilih(Request $request){
        $request->validate([
           'name' => 'required',
           'alamat' => 'required',
        ],[
            'name.required' => 'Nama Pemilih tidak boleh kosong',
            'alamat.required' => 'Alamat Pemilih tidak boleh kosong',
        ]);

        $detailpemilih = new DetailPemilih;
        $detailpemilih->name = $request->name;
        $detailpemilih->alamat = $request->alamat;
        $detailpemilih->id_detail_relawan = $request->id_detail_relawan;
        $detailpemilih->id_caleg = $request->id_caleg;
        $detailpemilih->save();
        return redirect()->back()->with('create', 'Data Detail Pemilih berhasil ditambahkan');
    }

    public function updatedetailpemilih(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'alamat' => 'required',
        ],[
            'name.required' => 'Nama Pemilih tidak boleh kosong',
            'alamat.required' => 'Alamat Pemilih tidak boleh kosong',
        ]);

        $detailpemilih = DetailPemilih::find($id);
        $detailpemilih->name = $request->name;
        $detailpemilih->alamat = $request->alamat;
        $detailpemilih->id_detail_relawan = $request->id_detail_relawan;
        $detailpemilih->id_caleg = $request->id_caleg;
        $detailpemilih->save();
        return redirect()->back()->with('update', 'Data Detail Pemilih berhasil diubah');
    }

    public function deletedetailpemilih($id){
        $detailpemilih = DetailPemilih::find($id);
        $detailpemilih->delete();
        return redirect()->back()->with('delete', 'Data Detail Pemilih berhasil dihapus');
    }

    // report 

    public function report(){
        // menampilkan jumlah suara per caleg berdasarkan kecamatan

        $bykecamatan = DB::table('tb_detail_pemilih')
        ->join('tb_detail_relawan', 'tb_detail_pemilih.id_detail_relawan', '=', 'tb_detail_relawan.id')
        ->join('tb_caleg', 'tb_detail_pemilih.id_caleg', '=', 'tb_caleg.id')
        ->join('tb_detail_tps', 'tb_detail_relawan.id_detail_tps', '=', 'tb_detail_tps.id')
        ->join('tb_detail_desa', 'tb_detail_tps.id_detail_desa', '=', 'tb_detail_desa.id')
        ->join('tb_desa', 'tb_detail_desa.id_desa', '=', 'tb_desa.id')
        ->join('tb_kecamatan', 'tb_desa.id_kecamatan', '=', 'tb_kecamatan.id')
        ->orderBy('tb_caleg.no_urut', 'asc')
        ->select('tb_caleg.name as caleg', 'tb_kecamatan.name as kecamatan', DB::raw('count(tb_detail_pemilih.id_caleg) as total'))
        ->groupBy('tb_caleg.name', 'tb_kecamatan.name')
        ->get();

        // menampilkan jumlah suara per caleg berdasarkan desa

        $bydesa = DB::table('tb_detail_pemilih')
        ->join('tb_detail_relawan', 'tb_detail_pemilih.id_detail_relawan', '=', 'tb_detail_relawan.id')
        ->join('tb_caleg', 'tb_detail_pemilih.id_caleg', '=', 'tb_caleg.id')
        ->join('tb_detail_tps', 'tb_detail_relawan.id_detail_tps', '=', 'tb_detail_tps.id')
        ->join('tb_detail_desa', 'tb_detail_tps.id_detail_desa', '=', 'tb_detail_desa.id')
        ->join('tb_desa', 'tb_detail_desa.id_desa', '=', 'tb_desa.id')
        ->join('tb_kecamatan', 'tb_desa.id_kecamatan', '=', 'tb_kecamatan.id')
        ->orderBy('tb_caleg.no_urut', 'asc')
        ->select('tb_caleg.name as caleg', 'tb_desa.name as desa', 'tb_kecamatan.name as kecamatan', DB::raw('count(tb_detail_pemilih.id_caleg) as total'))
        ->groupBy('tb_caleg.name', 'tb_desa.name', 'tb_kecamatan.name')
        ->get();

        // menampilkan jumlah suara per caleg berdasarkan tps serta nama desa

        $bytps = DB::table('tb_detail_pemilih')
        ->join('tb_detail_relawan', 'tb_detail_pemilih.id_detail_relawan', '=', 'tb_detail_relawan.id')
        ->join('tb_caleg', 'tb_detail_pemilih.id_caleg', '=', 'tb_caleg.id')
        ->join('tb_detail_tps', 'tb_detail_relawan.id_detail_tps', '=', 'tb_detail_tps.id')
        ->join('tb_detail_desa', 'tb_detail_tps.id_detail_desa', '=', 'tb_detail_desa.id')
        ->join('tb_desa', 'tb_detail_desa.id_desa', '=', 'tb_desa.id')
        ->join('tb_kecamatan', 'tb_desa.id_kecamatan', '=', 'tb_kecamatan.id')
        ->orderBy('tb_caleg.no_urut', 'asc')
        ->select('tb_caleg.name as caleg', 'tb_detail_tps.name as tps', 'tb_kecamatan.name as kecamatan', 'tb_desa.name as desa', DB::raw('count(tb_detail_pemilih.id_caleg) as total'))
        ->groupBy('tb_caleg.name', 'tb_detail_tps.name', 'tb_desa.name', 'tb_kecamatan.name')
        ->get();

        // menampilkan jumlah suara per caleg berdasarkan relawan serta nama tps dan desa

        $byrelawan = DB::table('tb_detail_pemilih')
        ->join('tb_detail_relawan', 'tb_detail_pemilih.id_detail_relawan', '=', 'tb_detail_relawan.id')
        ->join('tb_caleg', 'tb_detail_pemilih.id_caleg', '=', 'tb_caleg.id')
        ->join('tb_detail_tps', 'tb_detail_relawan.id_detail_tps', '=', 'tb_detail_tps.id')
        ->join('tb_detail_desa', 'tb_detail_tps.id_detail_desa', '=', 'tb_detail_desa.id')
        ->join('tb_desa', 'tb_detail_desa.id_desa', '=', 'tb_desa.id')
        ->join('tb_kecamatan', 'tb_desa.id_kecamatan', '=', 'tb_kecamatan.id')
        ->orderBy('tb_caleg.no_urut', 'asc')
       ->select('tb_caleg.name as caleg', 'tb_detail_relawan.name as relawan', 'tb_detail_tps.name as tps', 'tb_kecamatan.name as kecamatan', 'tb_desa.name as desa', DB::raw('count(tb_detail_pemilih.id_caleg) as total'))
        ->groupBy('tb_caleg.name', 'tb_detail_relawan.name', 'tb_detail_tps.name', 'tb_desa.name', 'tb_kecamatan.name')
        ->get();


        // menampilkan jumlah suara per caleg berdasarkan pemilih


        $bypemilih = DB::table('tb_detail_pemilih')
        ->join('tb_caleg', 'tb_detail_pemilih.id_caleg', '=', 'tb_caleg.id')
        ->orderBy('tb_caleg.no_urut', 'asc')
        ->select('tb_caleg.name as caleg', 'tb_detail_pemilih.name as pemilih', DB::raw('count(tb_detail_pemilih.id_caleg) as total'))
        ->groupBy('tb_caleg.name')
        ->get();

        return view('admin.pages.report',[
            'bykecamatan' => $bykecamatan,
            'bydesa' => $bydesa,
            'bytps' => $bytps,
            'byrelawan' => $byrelawan,
            'bypemilih' => $bypemilih,
        ]);
        
    }
}
