<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Classes;
use App\Models\Presence;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPengguna = User::count();
        $totalSiswa = Student::count();
        $totalKelas = Classes::count();

        $tanggalHariIni = Carbon::today()->toDateString();
        $totalHadir = Presence::whereDate('tanggal', $tanggalHariIni)
                        ->where('keterangan', 'Hadir')
                        ->count();
        $totalAbsensiHariIni = Presence::whereDate('tanggal', $tanggalHariIni)->count();

        $persentaseHadir = $totalSiswa > 0 
            ? round(($totalHadir / $totalSiswa) * 100, 2)
            : 0;

        return view('dashboard', compact('totalPengguna','totalSiswa','totalKelas','totalHadir','persentaseHadir'));
    }
}
