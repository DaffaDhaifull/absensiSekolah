<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\User;

class ClassesController extends Controller
{
    public function index()
    {
        $classes = Classes::with('users')->get();
        $users = User::where('role','guru')->get();
        return view('data.data_kelas', compact('classes','users'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'wali_kelas' => 'required',
        ],['required'=>'Data tidak boleh kosong']);
        return Classes::create($request->all()) ? redirect("/kelas")->with('success','Data berhasil disimpan.') : back()->with('error','Gagal menyimpan data!');
    }

    public function show(string $id)
    {
        $classes = Classes::find($id);
        return response()->json($classes);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $classes = Classes::find($id);
        $request->validate([
            'nama_kelas' => 'required',
            'wali_kelas' => 'required',
        ],['required'=>'Data tidak boleh kosong']);
        return $classes->update($request->all()) ? redirect("/kelas")->with('success','Data berhasil diperbarui.') : back()->with('error','Gagal meperbarui data!');
    }

    public function destroy(string $id)
    {
        return Classes::destroy($id) ? redirect("/kelas")->with('success','Data berhasil dihapus.') : back()->with('error','Data gagal dihapus.');
    }
}
