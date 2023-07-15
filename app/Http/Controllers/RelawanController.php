<?php

namespace App\Http\Controllers;

use App\Models\DetailRelawan;
use App\Models\Tps;
use App\Models\Relawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelawanController extends Controller
{
    public function index()
    {
        $relawan = DB::table('tb_relawan')
            ->join('tb_tps', 'tb_relawan.id_tps', '=', 'tb_tps.id')
            ->join('tb_desa', 'tb_tps.id_desa', '=', 'tb_desa.id')
            ->select('tb_relawan.*', 'tb_tps.id as id_tps', 'tb_tps.name as tps', 'tb_desa.name as desa')
            ->get();

        $tps = Tps::with('desa')->get();
        return view('admin.pages.relawan', [
            'relawan' => $relawan,
            'tps' => $tps
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_tps' => 'required',
            // 'nik' => 'unique:tb_relawan,nik',
            'name' => 'required',
            'alamat' => 'required'
        ], [
            'id_tps.required' => 'Nama TPS harus diisi!',
            'name.required' => 'Nama relawan harus diisi!',
            // 'nik.unique' => 'NIK sudah terdaftar!',
            'alamat.required' => 'Alamat relawan harus diisi!'
        ]);

        if ($request->nik == null) {
            Relawan::create([
                'id_tps' => $request->id_tps,
                'name' => $request->name,
                'nik' => '-',
                'alamat' => $request->alamat
            ]);
        } else {
            // cek apakah nik sudah terdaftar
            $cek = Relawan::where('nik', $request->nik)->first();
            if ($cek) {
                return redirect('/relawan')->with('niksudahada', 'NIK sudah terdaftar!');
            } else {
                Relawan::create([
                    'id_tps' => $request->id_tps,
                    'name' => $request->name,
                    'nik' => $request->nik,
                    'alamat' => $request->alamat
                ]);
            }
        }

        return redirect('/relawan')->with('create', 'Relawan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_tps' => 'required',
            'name' => 'required',
            // 'nik' => 'unique:tb_relawan,nik,' . $id,
            'alamat' => 'required'
        ], [
            'name.required' => 'Nama relawan harus diisi!',
            // 'nik.unique' => 'NIK sudah terdaftar!',
            'alamat.required' => 'Alamat relawan harus diisi!',
            'id_tps.required' => 'Nama TPS harus diisi!',
        ]);


        if ($request->nik == null) {
            $update = Relawan::find($id);
            $update->id_tps = $request->id_tps;
            $update->name = $request->name;
            $update->nik = '-';
            $update->alamat = $request->alamat;
            $update->save();
        } else {
            // cek apakah nik sudah terdaftar
            $cek = Relawan::where('nik', $request->nik)->where('id', '!=', $id)->first();
            if ($cek) {
                return redirect('/relawan')->with('niksudahada', 'NIK sudah terdaftar!');
            } else {
                $update = Relawan::find($id);
                $update->id_tps = $request->id_tps;
                $update->name = $request->name;
                $update->nik = $request->nik;
                $update->alamat = $request->alamat;
                $update->save();
            }
        }
        return redirect('/relawan')->with('update', 'Relawan berhasil diubah!');
    }

    public function destroy($id)
    {
        // cek apakah relawan sudah terdaftar di detail relawan

        $cek = DetailRelawan::where('id_relawan', $id)->first();
        if ($cek) {
            return redirect('/relawan')->with('relasidetailrelawan', 'Relawan tidak dapat dihapus karena sudah terdaftar di detail relawan!');
        } else {

            Relawan::find($id)->delete();
            return redirect('/relawan')->with('delete', 'Relawan berhasil dihapus!');
        }
    }
}
