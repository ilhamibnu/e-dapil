<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        Session::flash('email', $request->email);
        Session::flash('password', $request->password);

        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user == null) {

            return redirect()->intended('/login')->with('failed', 'login error');
        } else {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return redirect()->intended('/index')->with('loginberhasil', 'login berhasil');
            } else {
                return redirect()->intended('/login')->with('loginerror', 'login error');
            }
        }
    }

    public function updateprofil(Request $request, $id)
    {
        if ($request->oldpassword == null) {
            $request->validate(
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:tb_user,email,' . $id,
                ],
                [
                    'nama.required' => 'name tidak boleh kosong',
                    'email.email' => 'email tidak valid',
                    'email.required' => 'email tidak boleh kosong',
                    'email.unique' => 'email sudah terdaftar',
                ]
            );
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            return redirect()->intended('/index')->with('updateprofil', 'berhasil update profil');
        } else {

            $request->validate(
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:tb_user,email,' . $id,
                    'oldpassword' => 'required',
                    'password' => 'required',
                    'repassword' => 'required|same:password',
                ],
                [
                    'name.required' => 'name tidak boleh kosong',
                    'email.required' => 'email tidak boleh kosong',
                    'email.email' => 'email tidak valid',
                    'email.unique' => 'email sudah terdaftar',
                    'oldpassword.required' => 'oldpassword tidak boleh kosong',
                    // 'password.min' => 'password minimal 8 karakter',
                    'password.required' => 'password tidak boleh kosong',
                    'repassword.required' => 'repassword tidak boleh kosong',
                    'repassword.same' => 'repassword tidak sama dengan password',
                ]
            );

            if (Hash::check($request->oldpassword, Auth::user()->password)) {

                if ($request->password == $request->repassword) {

                    $user = User::find($id);
                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->password = bcrypt($request->password);
                    $user->save();
                    return redirect()->intended('/index')->with('updateprofil', 'berhasil update profil');
                } else {

                    return redirect()->intended('/index')->with('passwordtidaksama', 'gagal update profil');
                }
            } else {

                return redirect()->intended('/index')->with('updateprofilerror', 'gagal update profil');
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->intended('/login')->with('logout', 'berhasil logout');
    }
}
