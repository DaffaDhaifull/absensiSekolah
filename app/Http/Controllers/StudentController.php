<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Student;
use App\Models\Classes;
use App\Models\User;

class StudentController extends Controller
{
    public function index(Request $request)
    {
         $siswa = Student::with('classes');
         $kelas = Classes::all();

        if ($request->id_kelas) {
            $siswa->where('id_kelas', $request->id_kelas);
        }

        if ($request->search) {
            $siswa->where(function($q) use ($request){
                $q->where('nama_siswa', 'like', '%' . $request->search . '%')
                ->orWhere('nis', 'like', '%' . $request->search . '%');
            });
        }
        $siswa = $siswa->paginate(20)->withQueryString(); 

        return view('data.data_siswa', compact('siswa', 'kelas'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|unique:Students',
            'nama_siswa' => 'required',
            'jenis_kelamin' => 'required',
            'id_kelas' => 'required|exists:classes,id',
            'telepon_ortu' => 'required|string|max:15',
        ],[
            'telepon_ortu.max' => 'Telepon anda lebih dari 15 karakter.',
            'nis.unique' => 'Nis sudah digunakan',
            'required' => ':attribute anda kosong',
            'id_kelas.exists' => 'Kelas tidak terdaftar',
        ]);
        return Student::create($request->all()) ? redirect("/siswa")->with('success','Data berhasi disimpan.') : back()->with('error','Data gagal disimapan.');
    }

    public function show(string $id)
    {
        $siswa = Student::find($id);
        return response()->json($siswa);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nis' => 'required|string|unique:Students,nis,'.$id.',nis', //unique:nama_tabel,nama_kolom_yang_dicek,id_yang_dikecualikan,kolom_primary_key
            'nama_siswa' => 'required|string',
            'jenis_kelamin' => 'required',
            'id_kelas' => 'required|exists:classes,id',
            'telepon_ortu' => 'required|string|max:15',
        ],[
            'telepon_ortu.max' => 'Telepon anda lebih dari 15 karakter.',
            'required' => ':attribute anda kosong',
            'id_kelas.exists' => 'Kelas tidak terdaftar',
        ]);
        $siswa = Student::find($id);
        return $siswa->update($request->all()) 
            ? redirect("/siswa")->with('success', 'Data berhasil diperbarui.') 
            : redirect()->back()->with('error', 'Gagal memperbarui data.');
    }

    public function destroy(string $id)
    {
        return Student::destroy($id) 
            ? redirect("/siswa")->with('success', 'Data berhasil dihapus.') 
            : redirect()->back()->with('error', 'Gagal menghapus data.');
    }


    public function import(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ],[
            'file.mimes' => 'File yang anda unggah bukan xlsx / xls',
        ]);

        try {
            Excel::import(new StudentsImport, $request->file('file'));
        } catch (\Throwable $e) {
            return back()->withErrors(['file' => $e->getMessage()]);
        }

        return redirect()->back()->with('success', 'Data siswa berhasil diimport!');

    }
}


//Multipurpose Internet Mail Extensions