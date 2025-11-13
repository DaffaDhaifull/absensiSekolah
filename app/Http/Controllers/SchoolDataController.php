<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolData;

class SchoolDataController extends Controller
{

    public function index()
    {
        $school = SchoolData::first();
        return view('data.profile_sekolah', compact('school'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'namaSekolah'    => 'required|string|max:255',
            'namaSingkat'    => 'nullable|string|max:255',
            'NPSN'           => 'nullable|string|max:50',
            'jenjang'        => 'nullable|string|max:100',
            'status'         => 'required|in:Swasta,Negeri',
            'telepon'        => 'nullable|string|max:20',
            'email'          => 'nullable|email|max:100',
            'kepalaSekolah'  => 'nullable|string|max:255',
            'alamat'         => 'nullable|string',
            'logo'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $school = SchoolData::first();
        $filename = $school->logo;

        if ($request->hasFile('logo')) {
            if ($school && $school->logo && file_exists(public_path('assets/img/logo/' . $school->logo))) {
                unlink(public_path('assets/img/logo/' . $school->logo));
            }
            $pict = $request->file('logo');
            $filename = time() . $pict->hashName();
            $pict->move(public_path('assets/img/logo'), $filename);
        }

        if ($school) {
            $school->update($validated);
            $school->update([
                'logo' => $filename,
            ]);
            $message = 'Data sekolah berhasil diperbarui.';
        } else {
            SchoolData::create($validated);
            $school = SchoolData::latest()->first();
            $school->update([
                'logo' => $filename,
            ]);
            $message = 'Data sekolah berhasil disimpan.';
        }

        return redirect()->back()->with('success', $message);
    }
}
