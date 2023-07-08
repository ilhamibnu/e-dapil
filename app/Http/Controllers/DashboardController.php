<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {

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


        $namacaleg = $totalpemilih->pluck('caleg');
        $jumlahsuara = $totalpemilih->pluck('total');

        return view('admin.pages.index', [
            'namacaleg' => $namacaleg,
            'jumlahsuara' => $jumlahsuara,
        ]);
    }
}
