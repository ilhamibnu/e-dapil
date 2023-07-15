<?php

namespace App\Http\Controllers;

use App\Models\Tps;
use App\Models\Desa;
use App\Models\Caleg;
use App\Models\DetailTps;
use App\Models\Kecamatan;
use App\Models\DetailDesa;
use Illuminate\Http\Request;
use App\Models\DetailPemilih;
use App\Models\DetailRelawan;
use App\Models\DetailKecamatan;
use App\Models\Relawan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class CalegController extends Controller
{

    // crud caleg


    public function index()
    {
        $caleg = Caleg::all()->sortBy('no_urut');
        return view('admin.pages.caleg', [
            'caleg' => $caleg,
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'no_urut' => 'required',
            'foto' => 'required|max:5000|mimes:jpg,jpeg,png',
        ], [
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

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'no_urut' => 'required',
            'foto' => 'max:5000|mimes:jpg,jpeg,png',
        ], [
            'name.required' => 'Nama Caleg tidak boleh kosong',
            'no_urut.required' => 'No Urut tidak boleh kosong',
            'foto.max' => 'Foto maksimal 5MB',
            'foto.mimes' => 'Foto harus berformat jpg, jpeg, png',
        ]);

        if ($request->foto) {
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

    public function delete($id)
    {
        // cek apakah data caleg ada di tb_detail_kecamatan

        $detailkecamatan = DetailKecamatan::where('id_caleg', '=', $id)->get();
        if ($detailkecamatan->count() > 0) {
            return redirect()->back()->with('relasicaleg', 'data caleg tidak bisa dihapus karena masih terdapat data detail kecamatan');
        } else {

            $caleg = Caleg::find($id);
            File::delete('admin/foto/caleg/' . $caleg->foto);
            $caleg->delete();
            return redirect('/caleg')->with('delete', 'Data Caleg berhasil dihapus');
        }
    }

    // detail kecamatan

    public function detailkecamatan($id)
    {
        $kecamatan = Kecamatan::all();
        $caleg = Caleg::find($id);

        $detailkecamatan = DB::table('tb_detail_kecamatan')
            ->join('tb_kecamatan', 'tb_detail_kecamatan.id_kecamatan', '=', 'tb_kecamatan.id')
            ->join('tb_caleg', 'tb_detail_kecamatan.id_caleg', '=', 'tb_caleg.id')
            ->select('tb_detail_kecamatan.*', 'tb_kecamatan.name as kecamatan', 'tb_caleg.name as caleg')
            ->where('tb_detail_kecamatan.id_caleg', '=', $id)
            ->get();

        return view('admin.pages.detail-kecamatan', [
            'caleg' => $caleg,
            'kecamatan' => $kecamatan,
            'detailkecamatan' => $detailkecamatan,
        ]);
    }

    public function storedetailkecamatan(Request $request)
    {
        $request->validate([
            'id_kecamatan' => 'required',
        ], [
            'id_kecamatan.required' => 'Kecamatan tidak boleh kosong',
        ]);

        // cek apakah data caleg dan kecamatan sudah ada di tb_detail_kecamatan

        $detailkecamatan = DetailKecamatan::where('id_caleg', '=', $request->id_caleg)
            ->where('id_kecamatan', '=', $request->id_kecamatan)
            ->get();

        if ($detailkecamatan->count() > 0) {
            return redirect()->back()->with('kecamatancalegsudahada', 'data caleg dan kecamatan sudah ada');
        } else {

            $detailkecamatan = new DetailKecamatan;
            $detailkecamatan->id_kecamatan = $request->id_kecamatan;
            $detailkecamatan->id_caleg = $request->id_caleg;
            $detailkecamatan->save();
            return redirect()->back()->with('create', 'Data Detail Kecamatan berhasil ditambahkan');
        }
    }

    public function updatedetailkecamatan(Request $request, $id)
    {
        $request->validate([
            'id_kecamatan' => 'required',
        ], [
            'id_kecamatan.required' => 'Kecamatan tidak boleh kosong',
        ]);

        $detailkecamatan = DetailKecamatan::find($id);
        $detailkecamatan->id_kecamatan = $request->id_kecamatan;
        $detailkecamatan->id_caleg = $request->id_caleg;
        $detailkecamatan->save();
        return redirect()->back()->with('update', 'Data Detail Kecamatan berhasil diubah');
    }

    public function deletedetailkecamatan($id)
    {
        // cek apakah data detail kecamatan ada di tb_detail_desa

        $detaildesa = DetailDesa::where('id_detail_kecamatan', '=', $id)->get();
        if ($detaildesa->count() > 0) {
            return redirect()->back()->with('relasidetaildesa', 'data detail kecamatan tidak bisa dihapus karena masih terdapat data detail desa');
        } else {
            $detailkecamatan = DetailKecamatan::find($id);
            $detailkecamatan->delete();
            return redirect()->back()->with('delete', 'Data Detail Kecamatan berhasil dihapus');
        }
    }

    // detail desa

    public function detaildesa($id)
    {

        $datakecamatan = DetailKecamatan::find($id);
        $id_caleg = $datakecamatan->id_caleg;
        $id_kecamatan = $datakecamatan->id_kecamatan;

        $caleg = Caleg::find($id_caleg);
        $desa = Desa::with('kecamatan')->where('id_kecamatan', $id_kecamatan)->get();
        $detailkecamatan = DetailKecamatan::find($id);

        $detaildesa = DB::table('tb_detail_desa')
            ->join('tb_detail_kecamatan', 'tb_detail_desa.id_detail_kecamatan', '=', 'tb_detail_kecamatan.id')
            ->join('tb_desa', 'tb_detail_desa.id_desa', '=', 'tb_desa.id')
            ->join('tb_kecamatan', 'tb_desa.id_kecamatan', '=', 'tb_kecamatan.id')
            ->join('tb_caleg', 'tb_detail_kecamatan.id_caleg', '=', 'tb_caleg.id')
            ->select('tb_detail_desa.*', 'tb_detail_kecamatan.id_caleg', 'tb_desa.name as desa', 'tb_kecamatan.name as kecamatan', 'tb_caleg.name as caleg')
            ->where('tb_detail_kecamatan.id_caleg', '=', $id_caleg)
            ->where('tb_detail_kecamatan.id_kecamatan', '=', $id_kecamatan)
            ->get();


        return view('admin.pages.detail-desa', [
            'caleg' => $caleg,
            'desa' => $desa,
            'detaildesa' => $detaildesa,
            'detailkecamatan' => $detailkecamatan,
        ]);
    }

    public function storedetaildesa(Request $request)
    {
        $request->validate([
            'id_desa' => 'required',
        ], [
            'id_desa.required' => 'Desa tidak boleh kosong',
        ]);

        // cek apakah data caleg dan kecamatan sudah ada di tb_detail_kecamatan

        $detaildesa = DetailDesa::where('id_detail_kecamatan', '=', $request->id_detail_kecamatan)
            ->where('id_desa', '=', $request->id_desa)
            ->get();

        if ($detaildesa->count() > 0) {
            return redirect()->back()->with('desasudahada', 'data caleg dan desa sudah ada');
        } else {

            $detaildesa = new DetailDesa;
            $detaildesa->id_desa = $request->id_desa;
            $detaildesa->id_detail_kecamatan = $request->id_detail_kecamatan;
            $detaildesa->save();
            return redirect()->back()->with('create', 'Data Detail Desa berhasil ditambahkan');
        }
    }

    public function updatedetaildesa(Request $request, $id)
    {
        $request->validate([
            'id_desa' => 'required',
        ], [
            'id_desa.required' => 'Desa tidak boleh kosong',
        ]);

        $detaildesa = DetailDesa::find($id);
        $detaildesa->id_desa = $request->id_desa;
        $detaildesa->id_detail_kecamatan = $request->id_detail_kecamatan;
        $detaildesa->save();
        return redirect()->back()->with('update', 'Data Detail Desa berhasil diubah');
    }

    public function deletedetaildesa($id)
    {
        // cek apakah data detail desa ada di tb_detail_tps

        $detailtps = DetailTps::where('id_detail_desa', '=', $id)->get();
        if ($detailtps->count() > 0) {
            return redirect()->back()->with('relasidetailtps', 'data detail desa tidak bisa dihapus karena masih terdapat data detail tps');
        } else {

            $detaildesa = DetailDesa::find($id);
            $detaildesa->delete();
            return redirect()->back()->with('delete', 'Data Detail Desa berhasil dihapus');
        }
    }

    // detail tps

    public function detailtps($id)
    {

        $datadesa = DetailDesa::find($id);
        $datatps = Tps::where('id_desa', $datadesa->id_desa)->get();

        $id_desa = $datadesa->id;
        $id_detail_kecamatan = $datadesa->id_detail_kecamatan;

        $detailtps = DB::table('tb_detail_tps')
            ->join('tb_detail_desa', 'tb_detail_tps.id_detail_desa', '=', 'tb_detail_desa.id')
            ->join('tb_desa', 'tb_detail_desa.id_desa', '=', 'tb_desa.id')
            ->join('tb_kecamatan', 'tb_desa.id_kecamatan', '=', 'tb_kecamatan.id')
            ->join('tb_detail_kecamatan', 'tb_detail_kecamatan.id', '=', 'tb_detail_desa.id_detail_kecamatan')
            ->join('tb_caleg', 'tb_detail_kecamatan.id_caleg', '=', 'tb_caleg.id')
            ->join('tb_tps', 'tb_detail_tps.id_tps', '=', 'tb_tps.id')
            ->select('tb_detail_tps.*', 'tb_caleg.name as caleg', 'tb_tps.name as tps', 'tb_tps.id as id_tps')
            ->where('tb_detail_desa.id_detail_kecamatan', '=', $id_detail_kecamatan)
            ->where('tb_detail_desa.id', '=', $id_desa)
            ->get();


        return view('admin.pages.detail-tps', [
            // 'caleg' => $caleg,
            'datadesa' => $datadesa,
            'detailtps' => $detailtps,
            'datatps' => $datatps,
        ]);
    }

    public function storedetailtps(Request $request)
    {
        $request->validate([
            'id_tps' => 'required',
        ], [
            'id_tps.required' => 'TPS tidak boleh kosong',
        ]);

        // cek apakah data caleg dan desa sudah ada di tb_detail_tps

        $detailtps = DetailTps::where('id_detail_desa', '=', $request->id_detail_desa)
            ->where('id_tps', '=', $request->id_tps)
            ->get();

        if ($detailtps->count() > 0) {
            return redirect()->back()->with('tpssudahada', 'data caleg dan tps sudah ada');
        } else {

            $detailtps = new DetailTps;
            $detailtps->id_tps = $request->id_tps;
            $detailtps->id_detail_desa = $request->id_detail_desa;
            $detailtps->save();
            return redirect()->back()->with('create', 'Data Detail TPS berhasil ditambahkan');
        }
    }

    public function updatedetailtps(Request $request, $id)
    {
        $request->validate([
            'id_tps' => 'required',
        ], [
            'id_tps.required' => 'TPS tidak boleh kosong',
        ]);

        $detailtps = DetailTps::find($id);
        $detailtps->id_tps = $request->id_tps;
        $detailtps->id_detail_desa = $request->id_detail_desa;
        $detailtps->save();
        return redirect()->back()->with('update', 'Data Detail TPS berhasil diubah');
    }

    public function deletedetailtps($id)
    {
        // cek apakah data detail tps ada di tb_detail_relawan

        $detailrelawan = DetailRelawan::where('id_detail_tps', '=', $id)->get();
        if ($detailrelawan->count() > 0) {
            return redirect()->back()->with('relasidetailrelawan', 'data detail tps tidak bisa dihapus karena masih terdapat data detail relawan');
        } else {

            $detailtps = DetailTps::find($id);
            $detailtps->delete();
            return redirect()->back()->with('delete', 'Data Detail TPS berhasil dihapus');
        }
    }

    // detail relawatan

    public function detailrelawan($id)
    {

        $datatps = DetailTps::find($id);
        $id_tps = $datatps->id;
        $idtps = $datatps->id_tps;

        $datarelawan = Relawan::where('id_tps', $idtps)->get();

        $datadesa = DetailDesa::find($datatps->id_detail_desa);
        $id_desa = $datadesa->id;

        $datakecamatan = DetailKecamatan::find($datadesa->id_detail_kecamatan);
        $id_kecamatan = $datakecamatan->id;


        $detailrelawan = DB::table('tb_detail_relawan')
            ->join('tb_detail_tps', 'tb_detail_relawan.id_detail_tps', '=', 'tb_detail_tps.id')
            ->join('tb_detail_desa', 'tb_detail_tps.id_detail_desa', '=', 'tb_detail_desa.id')
            ->join('tb_desa', 'tb_detail_desa.id_desa', '=', 'tb_desa.id')
            ->join('tb_kecamatan', 'tb_desa.id_kecamatan', '=', 'tb_kecamatan.id')
            ->join('tb_detail_kecamatan', 'tb_detail_kecamatan.id', '=', 'tb_detail_desa.id_detail_kecamatan')
            ->join('tb_caleg', 'tb_detail_kecamatan.id_caleg', '=', 'tb_caleg.id')
            ->join('tb_relawan', 'tb_detail_relawan.id_relawan', '=', 'tb_relawan.id')
            ->select('tb_detail_relawan.*', 'tb_caleg.name as caleg', 'tb_relawan.id as id_relawan', 'tb_relawan.name as relawan')
            ->where('tb_detail_tps.id', '=', $id_tps)
            ->where('tb_detail_desa.id', '=', $id_desa)
            ->where('tb_detail_kecamatan.id', '=', $id_kecamatan)
            ->get();

        return view('admin.pages.detail-relawan', [
            'datatps' => $datatps,
            'detailrelawan' => $detailrelawan,
            'datarelawan' => $datarelawan,

        ]);
    }

    public function storedetailrelawan(Request $request)
    {
        $request->validate([
            'id_relawan' => 'required',

        ], [
            'id_relawan.required' => 'Nama Relawan tidak boleh kosong',
        ]);

        // cek apakah data caleg dan desa sudah ada di tb_detail_tps

        $detailrelawan = DetailRelawan::where('id_relawan', '=', $request->id_relawan)
            ->where('id_detail_tps', '=', $request->id_detail_tps)
            ->get();

        if ($detailrelawan->count() > 0) {
            return redirect()->back()->with('relawansudahada', 'data relawan dan tps sudah ada');
        } else {

            $detailrelawan = new DetailRelawan;
            $detailrelawan->id_relawan = $request->id_relawan;
            $detailrelawan->id_detail_tps = $request->id_detail_tps;
            $detailrelawan->save();
        }

        return redirect()->back()->with('create', 'Data Detail Relawan berhasil ditambahkan');
    }

    public function updatedetailrelawan(Request $request, $id)
    {
        $request->validate([
            'id_relawan' => 'required',
        ], [
            'id_relawan.required' => 'Nama Relawan tidak boleh kosong',
        ]);

        $detailrelawan = DetailRelawan::find($id);
        $detailrelawan->id_relawan = $request->id_relawan;
        $detailrelawan->id_detail_tps = $request->id_detail_tps;
        $detailrelawan->save();
        return redirect()->back()->with('update', 'Data Detail Relawan berhasil diubah');
    }

    public function deletedetailrelawan($id)
    {
        // cek apakah data detail relawan ada di tb_detail_pemilih

        $detailpemilih = DetailPemilih::where('id_detail_relawan', '=', $id)->get();
        if ($detailpemilih->count() > 0) {
            return redirect()->back()->with('relasidetailpemilih', 'data detail relawan tidak bisa dihapus karena masih terdapat data detail pemilih');
        } else {

            $detailrelawan = DetailRelawan::find($id);
            $detailrelawan->delete();
            return redirect()->back()->with('delete', 'Data Detail Relawan berhasil dihapus');
        }

    }

    // detail pemilih

    public function detailpemilih($id)
    {

        $datarelawan = DetailRelawan::find($id);
        $id_relawan = $datarelawan->id;

        $datatps = DetailTps::find($datarelawan->id_detail_tps);
        $id_tps = $datatps->id;

        $datadesa = DetailDesa::find($datatps->id_detail_desa);
        $id_desa = $datadesa->id;

        $datakecamatan = DetailKecamatan::find($datadesa->id_detail_kecamatan);
        $id_kecamatan = $datakecamatan->id;

        $detailpemilih = DB::table('tb_detail_pemilih')
            ->join('tb_detail_relawan', 'tb_detail_pemilih.id_detail_relawan', '=', 'tb_detail_relawan.id')
            ->join('tb_detail_tps', 'tb_detail_relawan.id_detail_tps', '=', 'tb_detail_tps.id')
            ->join('tb_detail_desa', 'tb_detail_tps.id_detail_desa', '=', 'tb_detail_desa.id')
            ->join('tb_desa', 'tb_detail_desa.id_desa', '=', 'tb_desa.id')
            ->join('tb_kecamatan', 'tb_desa.id_kecamatan', '=', 'tb_kecamatan.id')
            ->join('tb_detail_kecamatan', 'tb_detail_kecamatan.id', '=', 'tb_detail_desa.id_detail_kecamatan')
            ->join('tb_caleg', 'tb_detail_kecamatan.id_caleg', '=', 'tb_caleg.id')
            ->select('tb_detail_pemilih.*', 'tb_caleg.name as caleg')
            ->where('tb_detail_relawan.id', '=', $id_relawan)
            ->where('tb_detail_tps.id', '=', $id_tps)
            ->where('tb_detail_desa.id', '=', $id_desa)
            ->where('tb_detail_kecamatan.id', '=', $id_kecamatan)
            ->get();

        return view('admin.pages.detail-pemilih', [
            'datarelawan' => $datarelawan,
            'detailpemilih' => $detailpemilih,
        ]);
    }

    public function storedetailpemilih(Request $request)
    {
        $request->validate([
            'name' => 'required',
            // 'nik' => 'unique:tb_detail_pemilih',
            'alamat' => 'required',
        ], [
            'name.required' => 'Nama Pemilih tidak boleh kosong',
            // 'nik.unique' => 'NIK Pemilih sudah terdaftar',
            'alamat.required' => 'Alamat Pemilih tidak boleh kosong',
        ]);

        if ($request->nik == null) {

            $detailpemilih = new DetailPemilih;
            $detailpemilih->name = $request->name;
            $detailpemilih->nik = '-';
            $detailpemilih->alamat = $request->alamat;
            $detailpemilih->id_detail_relawan = $request->id_detail_relawan;
            $detailpemilih->save();
        } else {

            // cek nik sudah terdaftar atau belum

            $cek = DetailPemilih::where('nik', '=', $request->nik)->count();

            if ($cek > 0) {
                return redirect()->back()->with('niksudahada', 'NIK Pemilih sudah terdaftar');
            } else {

                $detailpemilih = new DetailPemilih;
                $detailpemilih->name = $request->name;
                $detailpemilih->nik = $request->nik;
                $detailpemilih->alamat = $request->alamat;
                $detailpemilih->id_detail_relawan = $request->id_detail_relawan;
                $detailpemilih->save();
            }
        }


        return redirect()->back()->with('create', 'Data Detail Pemilih berhasil ditambahkan');
    }

    public function updatedetailpemilih(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            // 'nik' => 'unique:tb_detail_pemilih,nik,' . $id,
            'alamat' => 'required',
        ], [
            'name.required' => 'Nama Pemilih tidak boleh kosong',
            'nik.unique' => 'NIK Pemilih sudah terdaftar',
            'alamat.required' => 'Alamat Pemilih tidak boleh kosong',
        ]);

        if ($request->nik == null) {

            $detailpemilih = DetailPemilih::find($id);
            $detailpemilih->name = $request->name;
            $detailpemilih->nik = '-';
            $detailpemilih->alamat = $request->alamat;
            $detailpemilih->id_detail_relawan = $request->id_detail_relawan;
            $detailpemilih->save();
        } else {

            // cek nik sudah terdaftar atau belum

            $cek = DetailPemilih::where('nik', '=', $request->nik)->where('id', '!=', $id)->count();

            if ($cek > 0) {
                return redirect()->back()->with('niksudahada', 'NIK Pemilih sudah terdaftar');
            } else {

                $detailpemilih = DetailPemilih::find($id);
                $detailpemilih->name = $request->name;
                $detailpemilih->nik = $request->nik;
                $detailpemilih->alamat = $request->alamat;
                $detailpemilih->id_detail_relawan = $request->id_detail_relawan;
                $detailpemilih->save();
            }
        }

        return redirect()->back()->with('update', 'Data Detail Pemilih berhasil diubah');
    }

    public function deletedetailpemilih($id)
    {
        $detailpemilih = DetailPemilih::find($id);
        $detailpemilih->delete();
        return redirect()->back()->with('delete', 'Data Detail Pemilih berhasil dihapus');
    }

    public function report()
    {
        // perolehan jumlah surat suara per caleg berdasarkan kecamatan

        $bykecamatan = DB::table('tb_detail_pemilih')
            ->join('tb_detail_relawan', 'tb_detail_pemilih.id_detail_relawan', '=', 'tb_detail_relawan.id')
            ->join('tb_detail_tps', 'tb_detail_relawan.id_detail_tps', '=', 'tb_detail_tps.id')
            ->join('tb_detail_desa', 'tb_detail_tps.id_detail_desa', '=', 'tb_detail_desa.id')
            ->join('tb_desa', 'tb_detail_desa.id_desa', '=', 'tb_desa.id')
            ->join('tb_kecamatan', 'tb_desa.id_kecamatan', '=', 'tb_kecamatan.id')
            ->join('tb_detail_kecamatan', 'tb_detail_kecamatan.id', '=', 'tb_detail_desa.id_detail_kecamatan')
            ->join('tb_caleg', 'tb_detail_kecamatan.id_caleg', '=', 'tb_caleg.id')
            ->select('tb_caleg.name as caleg', 'tb_kecamatan.name as kecamatan', DB::raw('count(tb_detail_pemilih.id) as total'))
            ->groupBy('tb_caleg.name')
            ->groupBy('tb_kecamatan.name')
            ->get();

        $ambilkecamatan = Kecamatan::all();
        $ambilcaleg = Caleg::all();

        return view('admin.pages.report2', [
            'bykecamatan' => $bykecamatan,
            'ambilkecamatan' => $ambilkecamatan,
            'ambilcaleg' => $ambilcaleg,
        ]);
    }

    public function totalpemilih()
    {
        // perolehan jumlah surata suara per caleg

        $totalpemilih = DB::table('tb_detail_pemilih')
            ->join('tb_detail_relawan', 'tb_detail_pemilih.id_detail_relawan', '=', 'tb_detail_relawan.id')
            ->join('tb_detail_tps', 'tb_detail_relawan.id_detail_tps', '=', 'tb_detail_tps.id')
            ->join('tb_detail_desa', 'tb_detail_tps.id_detail_desa', '=', 'tb_detail_desa.id')
            ->join('tb_desa', 'tb_detail_desa.id_desa', '=', 'tb_desa.id')
            ->join('tb_kecamatan', 'tb_desa.id_kecamatan', '=', 'tb_kecamatan.id')
            ->join('tb_detail_kecamatan', 'tb_detail_kecamatan.id', '=', 'tb_detail_desa.id_detail_kecamatan')
            ->join('tb_caleg', 'tb_detail_kecamatan.id_caleg', '=', 'tb_caleg.id')
            ->select('tb_caleg.name as caleg', DB::raw('count(tb_detail_pemilih.id) as total'))
            ->groupBy('tb_caleg.name')
            ->get();
    }

    public function report2($id)
    {

        // perolehan jumlah suara per caleg berdasarkan desa

        $bydesa = DB::table('tb_detail_pemilih')
            ->join('tb_detail_relawan', 'tb_detail_pemilih.id_detail_relawan', '=', 'tb_detail_relawan.id')
            ->join('tb_detail_tps', 'tb_detail_relawan.id_detail_tps', '=', 'tb_detail_tps.id')
            ->join('tb_detail_desa', 'tb_detail_tps.id_detail_desa', '=', 'tb_detail_desa.id')
            ->join('tb_desa', 'tb_detail_desa.id_desa', '=', 'tb_desa.id')
            ->join('tb_kecamatan', 'tb_desa.id_kecamatan', '=', 'tb_kecamatan.id')
            ->join('tb_detail_kecamatan', 'tb_detail_kecamatan.id', '=', 'tb_detail_desa.id_detail_kecamatan')
            ->join('tb_caleg', 'tb_detail_kecamatan.id_caleg', '=', 'tb_caleg.id')
            ->select('tb_caleg.name as caleg', 'tb_desa.name as desa', DB::raw('count(tb_detail_pemilih.id) as total'))
            ->groupBy('tb_caleg.name')
            ->groupBy('tb_desa.name')
            ->where('tb_kecamatan.id', '=', $id)
            ->get();

        $ambildesa = Desa::where('id_kecamatan', '=', $id)->get();
        $ambilcaleg = Caleg::all();
        $idkecamatan = $id;

        return view('admin.pages.report3', [
            'bydesa' => $bydesa,
            'ambildesa' => $ambildesa,
            'ambilcaleg' => $ambilcaleg,
            'idkecamatan' => $idkecamatan,
        ]);
    }

    public function report3($id)
    {

        // perolehan jumlah suara per caleg berdasarkan tps

        $bytps = DB::table('tb_detail_pemilih')
            ->join('tb_detail_relawan', 'tb_detail_pemilih.id_detail_relawan', '=', 'tb_detail_relawan.id')
            ->join('tb_detail_tps', 'tb_detail_relawan.id_detail_tps', '=', 'tb_detail_tps.id')
            ->join('tb_tps', 'tb_detail_tps.id_tps', '=', 'tb_tps.id')
            ->join('tb_detail_desa', 'tb_detail_tps.id_detail_desa', '=', 'tb_detail_desa.id')
            ->join('tb_desa', 'tb_detail_desa.id_desa', '=', 'tb_desa.id')
            ->join('tb_kecamatan', 'tb_desa.id_kecamatan', '=', 'tb_kecamatan.id')
            ->join('tb_detail_kecamatan', 'tb_detail_kecamatan.id', '=', 'tb_detail_desa.id_detail_kecamatan')
            ->join('tb_caleg', 'tb_detail_kecamatan.id_caleg', '=', 'tb_caleg.id')
            ->select('tb_caleg.name as caleg', DB::raw('count(tb_detail_pemilih.id) as total'))
            ->groupBy('tb_caleg.name')
            ->groupBy('tb_tps.name')
            ->where('tb_desa.id', '=', $id)
            ->get();


        $ambiltps = Tps::where('id_desa', '=', $id)->get();
        $ambilcaleg = Caleg::all();
        $iddesa = $id;

        return view('admin.pages.report4', [
            'bytps' => $bytps,
            'ambiltps' => $ambiltps,
            'ambilcaleg' => $ambilcaleg,
            'iddesa' => $iddesa,
        ]);
    }

    public function report4()
    {
        // jumlah relawan per caleg berdasarkan kecamatan

        $bykecamatan = DB::table('tb_detail_relawan')
            ->join('tb_relawan', 'tb_detail_relawan.id_relawan', '=', 'tb_relawan.id')
            ->join('tb_detail_tps', 'tb_detail_relawan.id_detail_tps', '=', 'tb_detail_tps.id')
            ->join('tb_detail_desa', 'tb_detail_tps.id_detail_desa', '=', 'tb_detail_desa.id')
            ->join('tb_desa', 'tb_detail_desa.id_desa', '=', 'tb_desa.id')
            ->join('tb_kecamatan', 'tb_desa.id_kecamatan', '=', 'tb_kecamatan.id')
            ->join('tb_detail_kecamatan', 'tb_detail_kecamatan.id', '=', 'tb_detail_desa.id_detail_kecamatan')
            ->join('tb_caleg', 'tb_detail_kecamatan.id_caleg', '=', 'tb_caleg.id')
            ->select('tb_caleg.name as caleg', 'tb_kecamatan.name as kecamatan', DB::raw('count(tb_detail_relawan.id) as total'))
            ->groupBy('tb_caleg.name')
            ->groupBy('tb_kecamatan.name')
            ->get();

        $ambilkecamatan = Kecamatan::all();
        $ambilcaleg = Caleg::all();

        return view('admin.pages.report5', [
            'bykecamatan' => $bykecamatan,
            'ambilkecamatan' => $ambilkecamatan,
            'ambilcaleg' => $ambilcaleg,
        ]);
    }

    public function report5($id)
    {
        // jumlah relawan per caleg berdasarkan desa

        $bydesa = DB::table('tb_detail_relawan')
            ->join('tb_relawan', 'tb_detail_relawan.id_relawan', '=', 'tb_relawan.id')
            ->join('tb_detail_tps', 'tb_detail_relawan.id_detail_tps', '=', 'tb_detail_tps.id')
            ->join('tb_detail_desa', 'tb_detail_tps.id_detail_desa', '=', 'tb_detail_desa.id')
            ->join('tb_desa', 'tb_detail_desa.id_desa', '=', 'tb_desa.id')
            ->join('tb_kecamatan', 'tb_desa.id_kecamatan', '=', 'tb_kecamatan.id')
            ->join('tb_detail_kecamatan', 'tb_detail_kecamatan.id', '=', 'tb_detail_desa.id_detail_kecamatan')
            ->join('tb_caleg', 'tb_detail_kecamatan.id_caleg', '=', 'tb_caleg.id')
            ->select('tb_caleg.name as caleg', 'tb_desa.name as desa', DB::raw('count(tb_detail_relawan.id) as total'))
            ->groupBy('tb_caleg.name')
            ->groupBy('tb_desa.name')
            ->where('tb_kecamatan.id', '=', $id)
            ->get();

        $ambildesa = Desa::where('id_kecamatan', '=', $id)->get();
        $ambilcaleg = Caleg::all();
        $idkecamatan = $id;

        return view('admin.pages.report6', [
            'bydesa' => $bydesa,
            'ambildesa' => $ambildesa,
            'ambilcaleg' => $ambilcaleg,
            'idkecamatan' => $idkecamatan,
        ]);
    }

    public function report6($id)
    {
        // jumlah relawan per caleg berdasarkan tps

        $bytps = DB::table('tb_detail_relawan')
            ->join('tb_relawan', 'tb_detail_relawan.id_relawan', '=', 'tb_relawan.id')
            ->join('tb_detail_tps', 'tb_detail_relawan.id_detail_tps', '=', 'tb_detail_tps.id')
            ->join('tb_tps', 'tb_detail_tps.id_tps', '=', 'tb_tps.id')
            ->join('tb_detail_desa', 'tb_detail_tps.id_detail_desa', '=', 'tb_detail_desa.id')
            ->join('tb_desa', 'tb_detail_desa.id_desa', '=', 'tb_desa.id')
            ->join('tb_kecamatan', 'tb_desa.id_kecamatan', '=', 'tb_kecamatan.id')
            ->join('tb_detail_kecamatan', 'tb_detail_kecamatan.id', '=', 'tb_detail_desa.id_detail_kecamatan')
            ->join('tb_caleg', 'tb_detail_kecamatan.id_caleg', '=', 'tb_caleg.id')
            ->select('tb_caleg.name as caleg', DB::raw('count(tb_detail_relawan.id) as total'))
            ->groupBy('tb_caleg.name')
            ->groupBy('tb_tps.name')
            ->where('tb_desa.id', '=', $id)
            ->get();


        $ambiltps = Tps::where('id_desa', '=', $id)->get();
        $ambilcaleg = Caleg::all();
        $iddesa = $id;

        return view('admin.pages.report7', [
            'bytps' => $bytps,
            'ambiltps' => $ambiltps,
            'ambilcaleg' => $ambilcaleg,
            'iddesa' => $iddesa,
        ]);
    }

    public function indexreportpemilih()
    {
        $datacaleg = Caleg::all();
        $datakecamatan = Kecamatan::all();
        // $datadesa = Desa::all();

        $test = DB::table('tb_detail_pemilih')
            ->join('tb_detail_relawan', 'tb_detail_pemilih.id_detail_relawan', '=', 'tb_detail_relawan.id')
            ->join('tb_relawan', 'tb_detail_relawan.id_relawan', '=', 'tb_relawan.id')
            ->join('tb_detail_tps', 'tb_detail_relawan.id_detail_tps', '=', 'tb_detail_tps.id')
            ->join('tb_tps', 'tb_detail_tps.id_tps', '=', 'tb_tps.id')
            ->join('tb_detail_desa', 'tb_detail_tps.id_detail_desa', '=', 'tb_detail_desa.id')
            ->join('tb_desa', 'tb_detail_desa.id_desa', '=', 'tb_desa.id')
            ->join('tb_kecamatan', 'tb_desa.id_kecamatan', '=', 'tb_kecamatan.id')
            ->join('tb_detail_kecamatan', 'tb_detail_kecamatan.id', '=', 'tb_detail_desa.id_detail_kecamatan')
            ->join('tb_caleg', 'tb_detail_kecamatan.id_caleg', '=', 'tb_caleg.id')
            ->select('tb_detail_pemilih.name as pemilih', 'tb_detail_pemilih.alamat as alamat')
            ->where('tb_caleg.id', '=', 0)
            ->where('tb_kecamatan.id', '=', 0)
            ->where('tb_desa.id', '=', 0)
            ->get();

        return view('admin.pages.report-pemilih', [
            'datakecamatan' => $datakecamatan,
            // 'datadesa' => $datadesa,
            'datacaleg' => $datacaleg,
            'datapemilih' => $test,
        ]);
    }

    public function tampildesa($id)
    {
        $datadesa = Desa::where('id_kecamatan', '=', $id)->get();
        return response()->json($datadesa);
    }

    public function reportpemilih(Request $request)
    {
        $request->validate([
            'id_caleg' => 'required',
            // 'id_kecamatan' => 'required',
        ], [
            'id_caleg.required' => 'Pilih Caleg',
            // 'id_kecamatan.required' => 'Pilih Kecamatan',
        ]);

        $id_caleg = $request->id_caleg;
        $id_kecamatan = $request->id_kecamatan;
        $id_desa = $request->id_desa;


        if ($id_kecamatan == null) {

            $datapemilih = DB::table('tb_detail_pemilih')
                ->join('tb_detail_relawan', 'tb_detail_pemilih.id_detail_relawan', '=', 'tb_detail_relawan.id')
                ->join('tb_relawan', 'tb_detail_relawan.id_relawan', '=', 'tb_relawan.id')
                ->join('tb_detail_tps', 'tb_detail_relawan.id_detail_tps', '=', 'tb_detail_tps.id')
                ->join('tb_tps', 'tb_detail_tps.id_tps', '=', 'tb_tps.id')
                ->join('tb_detail_desa', 'tb_detail_tps.id_detail_desa', '=', 'tb_detail_desa.id')
                ->join('tb_desa', 'tb_detail_desa.id_desa', '=', 'tb_desa.id')
                ->join('tb_kecamatan', 'tb_desa.id_kecamatan', '=', 'tb_kecamatan.id')
                ->join('tb_detail_kecamatan', 'tb_detail_kecamatan.id', '=', 'tb_detail_desa.id_detail_kecamatan')
                ->join('tb_caleg', 'tb_detail_kecamatan.id_caleg', '=', 'tb_caleg.id')
                ->select('tb_detail_pemilih.name as pemilih', 'tb_detail_pemilih.alamat as alamat')
                ->where('tb_caleg.id', '=', $id_caleg)
                ->get();
        } elseif ($id_desa == null) {
            $datapemilih = DB::table('tb_detail_pemilih')
                ->join('tb_detail_relawan', 'tb_detail_pemilih.id_detail_relawan', '=', 'tb_detail_relawan.id')
                ->join('tb_relawan', 'tb_detail_relawan.id_relawan', '=', 'tb_relawan.id')
                ->join('tb_detail_tps', 'tb_detail_relawan.id_detail_tps', '=', 'tb_detail_tps.id')
                ->join('tb_tps', 'tb_detail_tps.id_tps', '=', 'tb_tps.id')
                ->join('tb_detail_desa', 'tb_detail_tps.id_detail_desa', '=', 'tb_detail_desa.id')
                ->join('tb_desa', 'tb_detail_desa.id_desa', '=', 'tb_desa.id')
                ->join('tb_kecamatan', 'tb_desa.id_kecamatan', '=', 'tb_kecamatan.id')
                ->join('tb_detail_kecamatan', 'tb_detail_kecamatan.id', '=', 'tb_detail_desa.id_detail_kecamatan')
                ->join('tb_caleg', 'tb_detail_kecamatan.id_caleg', '=', 'tb_caleg.id')
                ->select('tb_detail_pemilih.name as pemilih', 'tb_detail_pemilih.alamat as alamat')
                ->where('tb_caleg.id', '=', $id_caleg)
                ->where('tb_kecamatan.id', '=', $id_kecamatan)
                ->get();
        } else {
            $datapemilih = DB::table('tb_detail_pemilih')
                ->join('tb_detail_relawan', 'tb_detail_pemilih.id_detail_relawan', '=', 'tb_detail_relawan.id')
                ->join('tb_relawan', 'tb_detail_relawan.id_relawan', '=', 'tb_relawan.id')
                ->join('tb_detail_tps', 'tb_detail_relawan.id_detail_tps', '=', 'tb_detail_tps.id')
                ->join('tb_tps', 'tb_detail_tps.id_tps', '=', 'tb_tps.id')
                ->join('tb_detail_desa', 'tb_detail_tps.id_detail_desa', '=', 'tb_detail_desa.id')
                ->join('tb_desa', 'tb_detail_desa.id_desa', '=', 'tb_desa.id')
                ->join('tb_kecamatan', 'tb_desa.id_kecamatan', '=', 'tb_kecamatan.id')
                ->join('tb_detail_kecamatan', 'tb_detail_kecamatan.id', '=', 'tb_detail_desa.id_detail_kecamatan')
                ->join('tb_caleg', 'tb_detail_kecamatan.id_caleg', '=', 'tb_caleg.id')
                ->select('tb_detail_pemilih.name as pemilih', 'tb_detail_pemilih.alamat as alamat')
                ->where('tb_caleg.id', '=', $id_caleg)
                ->where('tb_kecamatan.id', '=', $id_kecamatan)
                ->where('tb_desa.id', '=', $id_desa)
                ->get();
        }

        $datacaleg = Caleg::all();
        $datakecamatan = Kecamatan::all();
        $datadesa = Desa::all();

        return view('admin.pages.report-pemilih', [
            'datapemilih' => $datapemilih,
            'datacaleg' => $datacaleg,
            'datakecamatan' => $datakecamatan,
            'datadesa' => $datadesa,
        ]);
    }


    public function indexreportrelawan()
    {
        $datacaleg = Caleg::all();
        $datakecamatan = Kecamatan::all();
        // $datadesa = Desa::all();

        $test = DB::table('tb_detail_relawan')
            ->join('tb_relawan', 'tb_detail_relawan.id_relawan', '=', 'tb_relawan.id')
            ->join('tb_detail_tps', 'tb_detail_relawan.id_detail_tps', '=', 'tb_detail_tps.id')
            ->join('tb_tps', 'tb_detail_tps.id_tps', '=', 'tb_tps.id')
            ->join('tb_detail_desa', 'tb_detail_tps.id_detail_desa', '=', 'tb_detail_desa.id')
            ->join('tb_desa', 'tb_detail_desa.id_desa', '=', 'tb_desa.id')
            ->join('tb_kecamatan', 'tb_desa.id_kecamatan', '=', 'tb_kecamatan.id')
            ->join('tb_detail_kecamatan', 'tb_detail_kecamatan.id', '=', 'tb_detail_desa.id_detail_kecamatan')
            ->join('tb_caleg', 'tb_detail_kecamatan.id_caleg', '=', 'tb_caleg.id')
            ->select('tb_relawan.name as relawan', 'tb_relawan.alamat as alamat')
            ->where('tb_kecamatan.id', '=', 0)
            ->where('tb_desa.id', '=', 0)
            ->get();

        return view('admin.pages.report-relawan', [
            'datakecamatan' => $datakecamatan,
            // 'datadesa' => $datadesa,
            'datacaleg' => $datacaleg,
            'datarelawan' => $test,
        ]);
    }

    public function tampildesarelawan($id)
    {
        $datadesa = Desa::where('id_kecamatan', '=', $id)->get();
        return response()->json($datadesa);
    }

    public function reportrelawan(Request $request)
    {
        $request->validate([
            'id_caleg' => 'required',
            // 'id_kecamatan' => 'required',
        ], [
            'id_caleg.required' => 'Pilih Caleg',
            // 'id_kecamatan.required' => 'Pilih Kecamatan',
        ]);

        $id_caleg = $request->id_caleg;
        $id_kecamatan = $request->id_kecamatan;
        $id_desa = $request->id_desa;


        if ($id_kecamatan == null) {

            $datarelawan = DB::table('tb_detail_relawan')
                ->join('tb_relawan', 'tb_detail_relawan.id_relawan', '=', 'tb_relawan.id')
                ->join('tb_detail_tps', 'tb_detail_relawan.id_detail_tps', '=', 'tb_detail_tps.id')
                ->join('tb_tps', 'tb_detail_tps.id_tps', '=', 'tb_tps.id')
                ->join('tb_detail_desa', 'tb_detail_tps.id_detail_desa', '=', 'tb_detail_desa.id')
                ->join('tb_desa', 'tb_detail_desa.id_desa', '=', 'tb_desa.id')
                ->join('tb_kecamatan', 'tb_desa.id_kecamatan', '=', 'tb_kecamatan.id')
                ->join('tb_detail_kecamatan', 'tb_detail_kecamatan.id', '=', 'tb_detail_desa.id_detail_kecamatan')
                ->join('tb_caleg', 'tb_detail_kecamatan.id_caleg', '=', 'tb_caleg.id')
                ->select('tb_relawan.name as relawan', 'tb_relawan.alamat as alamat')
                ->where('tb_caleg.id', '=', $id_caleg)
                ->get();
        } elseif ($id_desa == null) {

            $datarelawan = DB::table('tb_detail_relawan')
                ->join('tb_relawan', 'tb_detail_relawan.id_relawan', '=', 'tb_relawan.id')
                ->join('tb_detail_tps', 'tb_detail_relawan.id_detail_tps', '=', 'tb_detail_tps.id')
                ->join('tb_tps', 'tb_detail_tps.id_tps', '=', 'tb_tps.id')
                ->join('tb_detail_desa', 'tb_detail_tps.id_detail_desa', '=', 'tb_detail_desa.id')
                ->join('tb_desa', 'tb_detail_desa.id_desa', '=', 'tb_desa.id')
                ->join('tb_kecamatan', 'tb_desa.id_kecamatan', '=', 'tb_kecamatan.id')
                ->join('tb_detail_kecamatan', 'tb_detail_kecamatan.id', '=', 'tb_detail_desa.id_detail_kecamatan')
                ->join('tb_caleg', 'tb_detail_kecamatan.id_caleg', '=', 'tb_caleg.id')
                ->select('tb_relawan.name as relawan', 'tb_relawan.alamat as alamat')
                ->where('tb_caleg.id', '=', $id_caleg)
                ->where('tb_kecamatan.id', '=', $id_kecamatan)
                ->get();
        } else {
            $datarelawan = DB::table('tb_detail_relawan')
                ->join('tb_relawan', 'tb_detail_relawan.id_relawan', '=', 'tb_relawan.id')
                ->join('tb_detail_tps', 'tb_detail_relawan.id_detail_tps', '=', 'tb_detail_tps.id')
                ->join('tb_tps', 'tb_detail_tps.id_tps', '=', 'tb_tps.id')
                ->join('tb_detail_desa', 'tb_detail_tps.id_detail_desa', '=', 'tb_detail_desa.id')
                ->join('tb_desa', 'tb_detail_desa.id_desa', '=', 'tb_desa.id')
                ->join('tb_kecamatan', 'tb_desa.id_kecamatan', '=', 'tb_kecamatan.id')
                ->join('tb_detail_kecamatan', 'tb_detail_kecamatan.id', '=', 'tb_detail_desa.id_detail_kecamatan')
                ->join('tb_caleg', 'tb_detail_kecamatan.id_caleg', '=', 'tb_caleg.id')
                ->select('tb_relawan.name as relawan', 'tb_relawan.alamat as alamat')
                ->where('tb_caleg.id', '=', $id_caleg)
                ->where('tb_kecamatan.id', '=', $id_kecamatan)
                ->where('tb_desa.id', '=', $id_desa)
                ->get();
        }

        $datacaleg = Caleg::all();
        $datakecamatan = Kecamatan::all();
        $datadesa = Desa::all();

        return view('admin.pages.report-relawan', [
            'datarelawan' => $datarelawan,
            'datacaleg' => $datacaleg,
            'datakecamatan' => $datakecamatan,
            'datadesa' => $datadesa,
        ]);
    }
}
