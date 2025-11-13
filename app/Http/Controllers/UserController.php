<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('data.data_pengguna', compact('users'));
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'telepon' => 'required|string|max:15',
            'role' => 'required|in:admin,guru',
        ],[
            'email.email' => 'Email yang Anda masukkan tidak valid.',
            'email.unique' => 'Email anda sudah terdaftar',
            'password.min' => 'Password minimal 6 karakter.',
            'telepon.max' => 'Telepon anda lebih dari 15 karakter.',
            'role.in' => 'Role yang dipilih tidak valid.',
            'required' => ':attribute anda kosong',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telepon' => $request->telepon,
            'role' => $request->role,
        ]);
        
        return redirect("/pengguna")->with('success', 'Data berhasil disimpan.');
    }
    public function show(string $id)
    {
        $user = User::find($id);
        return response()->json($user);
    }
    public function edit(string $id)
    {
        //
    }
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id, //unique:nama_tabel,nama_kolom,ID_yang_dikecualikan 
            'telepon' => 'required|string|max:15',
            'role' => 'required|in:admin,guru',
        ],[
            'email.email' => 'Email yang Anda masukkan tidak valid.',
            'email.unique' => 'Email anda sudah terdaftar',
            'telepon.max' => 'Telepon anda lebih dari 15 karakter.',
            'role.in' => 'Role yang dipilih tidak valid.',
            'required' => ':attribute anda kosong',
        ]);
        return $user->update($request->all()) ? redirect("/pengguna")->with('success', 'Data berhasil diperbarui.') : redirect()->back()->with('error', 'Gagal memperbarui data.');
    }
    public function destroy(string $id)
    {
        return User::destroy($id) ? redirect("/pengguna") : exit();
    }
}
