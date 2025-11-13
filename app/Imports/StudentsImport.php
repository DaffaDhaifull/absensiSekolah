<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class StudentsImport implements ToModel,  WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function headingRow(): int
    {
        return 4;
    }


    public function model(array $row)
    {
        Validator::make($row, [
            'nis'           => 'required|unique:students,nis',
            'nama_lengkap'  => 'required',
            'jenis_kelamin' => 'required',
            'kelas'         => 'required',
        ],[
            'nis.required' => 'Kolom NIS harus diisi.',
            'nis.unique' => 'NIS ' . $row['nis'] . ' sudah terdaftar di database.',
            'nama_lengkap.required' => 'Nama siswa tidak boleh kosong.',
            'jenis_kelamin.required' => 'Jenis kelamin tidak boleh kosong.',
            'kelas.required' => 'Kelas wajib diisi.',
        ])->validate();

        return new Student([

            'nis'           => $row['nis'],
            'nama_siswa'    => $row['nama_lengkap'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'id_kelas'      => $row['kelas'],
            'telepon_ortu'  => $row['nomor_tlp_ortu'],
        ]);
    }
}
