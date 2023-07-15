<?php

namespace App\Http\Controllers;

use App\Models\Tps;
use App\Models\Desa;
use App\Models\DetailTps;
use App\Models\Kecamatan;
use App\Models\Relawan;
use Illuminate\Http\Request;


class TpsController extends Controller
{
    public function index()
    {
        $kecamatan = Kecamatan::all();
        $desa = Desa::all();
        $tps = Tps::with('desa')->get();
        return view('admin.pages.tps', [
            'tps' => $tps,
            'desa' => $desa,
            'kecamatan' => $kecamatan,
        ]);
    }

    public function caridesa($id)
    {
        $desa = Desa::where('id_kecamatan', $id)->get();
        return response()->json($desa);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah_tps' => 'required',
            'id_desa' => 'required',
        ], [
            'jumlah_tps.required' => 'Jumlah TPS harus diisi!',
        ]);

        // pengecekan apakah tps sudah ada atau belum, apabila belum ada maka akan dibuatkan tps berdasarkan jumlah tps yang diinputkan, apabila sudah ada maka akan diupdate jumlah tpsnya berdasarkan jumlah tps yang diinputkan
        $cek = Tps::where('id_desa', $request->id_desa)->first();

        if ($cek == null) {
            for ($i = 1; $i <= $request->jumlah_tps; $i++) {
                $tps = new Tps;
                $tps->id_desa = $request->id_desa;
                $tps->name = 'TPS ' . $i;
                $tps->save();
            }

            return redirect('/tps')->with('create', 'TPS berhasil ditambahkan!');
        } else {

            $jumlahtpsyangada = Tps::where('id_desa', $request->id_desa)->count();
            $jumlahtpsyangdiinputkan = $request->jumlah_tps;

            if ($jumlahtpsyangada > $jumlahtpsyangdiinputkan) {
                $selisih = $jumlahtpsyangada - $jumlahtpsyangdiinputkan;
                for ($i = 1; $i <= $selisih; $i++) {
                    $tps = Tps::where('id_desa', $request->id_desa)->orderBy('id', 'desc')->first();
                    $tps->delete();
                }

                return redirect('/tps')->with('create', 'TPS berhasil ditambahkan!');
            } else if ($jumlahtpsyangada < $jumlahtpsyangdiinputkan) {
                $selisih = $jumlahtpsyangdiinputkan - $jumlahtpsyangada;
                for ($i = 1; $i <= $selisih; $i++) {
                    $tps = new Tps;
                    $tps->id_desa = $request->id_desa;
                    // nama tps akan diinputkan sesuai dengan jumlah tps yang ada di desa tersebut
                    $tps->name = 'TPS ' . ($jumlahtpsyangada + $i);
                    $tps->save();
                }

                return redirect('/tps')->with('create', 'TPS berhasil ditambahkan!');
            } else {
                return redirect('/tps')->with('create', 'TPS berhasil ditambahkan!');
            }
        }
    }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'id_desa' => 'required',
    //     ], [
    //         'name.required' => 'Nama TPS harus diisi!',
    //     ]);

    //     $update = Tps::find($id);
    //     $update->id_desa = $request->id_desa;
    //     $update->name = $request->name;
    //     $update->save();

    //     return redirect('/tps')->with('update', 'TPS berhasil diubah!');
    // }

    public function destroy($id)
    {
        // cek apakah tps sudah ada data detail tps atau belum
        // cek apakah tps sudah ada data relawan atau belum

        $cekdetailtps = DetailTps::where('id_tps', $id)->first();
        $cekrelawan = Relawan::where('id_tps', $id)->first();

        if ($cekdetailtps) {
            return redirect('/tps')->with('relasidetailtps', 'TPS gagal dihapus karena sudah ada data detail TPS!');
        } elseif ($cekrelawan) {
            return redirect('/tps')->with('relasirelawan', 'TPS gagal dihapus karena sudah ada data relawan!');
        } else {
            Tps::find($id)->delete();
            return redirect('/tps')->with('delete', 'TPS berhasil dihapus!');
        }
    }
}
