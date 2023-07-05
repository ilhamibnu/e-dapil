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

class ReportController extends Controller
{
    public function index(){

        // // data suara per kecamatan
        // $bykecamatan = DB::table('tb_detail_pemilih')
        // ->join('tb_detail_relawan', 'tb_detail_pemilih.id_detail_relawan', '=', 'tb_detail_relawan.id')
        // ->join('tb_caleg', 'tb_detail_pemilih.id_caleg', '=', 'tb_caleg.id')
        // ->join('tb_detail_tps', 'tb_detail_relawan.id_detail_tps', '=', 'tb_detail_tps.id')
        // ->join('tb_detail_desa', 'tb_detail_tps.id_detail_desa', '=', 'tb_detail_desa.id')
        // ->join('tb_desa', 'tb_detail_desa.id_desa', '=', 'tb_desa.id')
        // ->join('tb_kecamatan', 'tb_desa.id_kecamatan', '=', 'tb_kecamatan.id')
        // ->orderBy('tb_caleg.no_urut', 'asc')
        // ->select('tb_caleg.name as caleg', 'tb_kecamatan.name as kecamatan', DB::raw('count(tb_detail_pemilih.id_caleg) as total'))
        // ->groupBy('tb_caleg.name', 'tb_kecamatan.name')
        // ->get();

        // $ambilkecamatan = Kecamatan::pluck('name');
        // $ambilcaleg = Caleg::pluck('name');

        return view('admin.pages.report2', [
            
        ]);
    }

    public function indexdesa($id){
    }
}
