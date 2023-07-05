<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {

        // $bypemilih = DB::table('tb_detail_pemilih')
        // ->join('tb_caleg', 'tb_detail_pemilih.id_caleg', '=', 'tb_caleg.id')
        // ->select('tb_caleg.name as caleg', 'tb_detail_pemilih.name as pemilih', DB::raw('count(tb_detail_pemilih.id_caleg) as total'))
        // ->groupBy('tb_caleg.name')
        // ->get();


        // $namacaleg = $bypemilih->pluck('caleg');
        // $jumlahsuara = $bypemilih->pluck('total');

        return view('admin.pages.index', [
            // 'namacaleg' => $namacaleg,
            // 'jumlahsuara' => $jumlahsuara,
        ]);

    }

}
