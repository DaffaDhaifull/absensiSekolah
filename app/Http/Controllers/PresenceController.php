<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\LaporanAbsensiExport;
use App\Http\Controllers\SendMessageController;
use Carbon\Carbon;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Presence;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PresenceController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();
        $siswa = collect([]);
        $tanggal = $request->input('tanggal', date('Y-m-d'));

        if ($user->role === 'guru') {
            $kelas = Classes::where('wali_kelas', $user->id)->get(); 
            $kelas_id = $request->input('id_kelas', $kelas->first()?->id ?? null); //(?->) nullsafe operator
        } else {
            $kelas = Classes::all();
            $kelas_id = $request->input('id_kelas');
        }


        if ($kelas_id) {
            $siswa = Student::with('classes')
                ->where('id_kelas', $kelas_id)
                ->orderBy('nama_siswa', 'asc')
                ->get();

            $absensi = Presence::where('tanggal', $tanggal)
                ->whereIn('nis', $siswa->pluck('nis'))
                ->get()
                ->keyBy('nis');

            $absensiAda = $siswa->isNotEmpty() 
                ? Presence::where('tanggal', $tanggal)
                    ->whereIn('nis', $siswa->pluck('nis'))
                    ->exists()
                : false;
                
        } else {
            $absensi = collect([]);
            $absensiAda = false;
        }

        return view("data.data_absensi", compact('kelas', 'siswa', 'absensi', 'tanggal', 'kelas_id', 'absensiAda', 'user'));
    }





    public function store(Request $request){
        $user = Auth::user();
        $tanggal = $request->tanggal ?? date('Y-m-d');
        $kelas_id = $user->role === 'guru'
            ? Classes::where('wali_kelas', $user->id)->first()?->id ?? null
            : $request->kelas_id;

        $request->validate([
            'tanggal' => 'required|date|before_or_equal:today',
            'siswa_ids' => 'required|array',
            'keterangan' => 'required|array',
        ],[
            'tanggal.before_or_equal'=> 'Pengisian absensi tidak diperbolehkan untuk tanggal esok atau tanggal yang belum terjadi.'
        ]);

        foreach ($request->siswa_ids as $siswa_id) {
            $sudahAda = Presence::whereDate('tanggal', $tanggal)
                ->where('nis', $siswa_id)
                ->exists();

            if ($sudahAda) {
                return back()->with('error', 'Absensi siswa ini sudah dicatat hari ini.');
            }
        }

        $warning = [];

        foreach ($request->siswa_ids as $siswa_id) {
            $keterangan = $request->keterangan[$siswa_id] ?? 'Hadir';

            Presence::create([
                'nis'        => $siswa_id,
                'tanggal'    => $tanggal,
                'keterangan' => $keterangan,
                'id_guru'    => $user->id,
            ]);


            if ($keterangan === 'Alpa' || $keterangan === null) {
                $siswa = Student::find($siswa_id);
                if ($siswa) {
                    $kirim = app(SendMessageController::class)->kirimAbsen($siswa->nama_siswa, $siswa->nis, $siswa->telepon_ortu,$tanggal);

                    if (!$kirim['success']) {
                         $warning['warning_'.$siswa->nis] = $siswa->nama_siswa . ': ' . $kirim['msg'];
                    }
                }
            }
        }
        return redirect()->route('absensi.index', ['id_kelas' => $kelas_id,'tanggal' => $tanggal])
            ->with($warning)->with('success', 'Absensi berhasil disimpan!');
    }





    public function update(Request $request)
    {
        $user = Auth::user();
        $tanggal = $request->tanggal ?? date('Y-m-d');

        $kelas_id = $user->role === 'guru'
            ? Classes::where('wali_kelas', $user->id)->first()?->id ?? null
            : $request->id_kelas;

        $request->validate([
            'siswa_ids' => 'required|array',
            'keterangan' => 'required|array',
        ]);

        foreach ($request->siswa_ids as $siswa_id) {
            $keterangan = $request->keterangan[$siswa_id] ?? 'Hadir';

            Presence::updateOrCreate(
                ['nis' => $siswa_id, 'tanggal' => $tanggal],
                ['keterangan' => $keterangan, 'id_guru' => $user->id],
            );
        }

        return redirect()->route('absensi.index', [
            'id_kelas' => $kelas_id,
            'tanggal' => $tanggal
        ])->with('success', 'Absensi berhasil diperbarui!');
    }





    public function showLap(Request $request)
    {
        $kelas = Classes::all();
        $tanggalAwal = $request->input('tanggal_awal', date('Y-m-01'));
        $tanggalAkhir = $request->input('tanggal_akhir', date('Y-m-d'));

        $start = \Carbon\Carbon::parse($tanggalAwal);
        $end = \Carbon\Carbon::parse($tanggalAkhir);
        
        $tanggal_range = [];
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) { //lebih kecil sama dengan(lte).
            if (!$date->isWeekend()) {
                $tanggal_range[] = $date->format('Y-m-d');
            }
        }
        if (count($tanggal_range) === 0) {
            return redirect()->back()->with('error', 'Tanggal tersebut tidak ada absensi.');
        }

        $siswa = Student::with('classes')->when($request->id_kelas, fn($q) => $q->where('id_kelas', $request->id_kelas))->get();

        $absensi_raw = Presence::whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->when($request->id_kelas, fn($q) => $q->whereHas('student', fn($q2) => $q2->where('id_kelas', $request->id_kelas)))->get();

        $absensi = [];
        foreach ($siswa as $s) {
            $absensi[$s->nis] = [];
            foreach ($tanggal_range as $tgl) {
                $record = $absensi_raw->firstWhere(fn($a) => $a->nis == $s->nis && $a->tanggal == $tgl);
                if ($record) {
                    $status = match($record->keterangan) {
                        'Hadir' => 'H',
                        'Sakit' => 'S',
                        'Izin'  => 'I',
                        'Alpa'  => 'A',
                        default => '',
                    };
                    $absensi[$s->nis][$tgl] = $status;
                } else {
                    $absensi[$s->nis][$tgl] = '';
                }
            }
        }

        $bulan_range = collect($tanggal_range)
            ->map(function($tgl) { return \Carbon\Carbon::parse($tgl)->format('Y-m'); })
            ->unique()
            ->values();
        $isRekapBulanan = $bulan_range->count() > 1;


        $rekapBulanan = [];
        if ($isRekapBulanan) {
            foreach ($siswa as $s) {
                foreach ($bulan_range as $bln) {
                    $rekapBulanan[$s->nis][$bln] = ['H' => 0, 'S' => 0, 'I' => 0, 'A' => 0];
                }
                foreach ($tanggal_range as $tgl) {
                    $bulanKey = \Carbon\Carbon::parse($tgl)->format('Y-m');
                    $status = $absensi[$s->nis][$tgl] ?? '';
                    if (isset($rekapBulanan[$s->nis][$bulanKey][$status])) {
                        $rekapBulanan[$s->nis][$bulanKey][$status]++;
                    }
                }
            }
        }

        return view('data.lap_absensi', compact(
            'tanggal_range', 'kelas', 'siswa', 'absensi', 'bulan_range', 'rekapBulanan', 'isRekapBulanan',
        ));
    }





    public function export(Request $request)
    {
        // $siswa = Student::all();
        $tanggalAwal = $request->input('tanggal_awal', date('Y-m-01'));
        $tanggalAkhir = $request->input('tanggal_akhir', date('Y-m-d'));
        $kelas_id = $request->input('id_kelas');

        $start = Carbon::parse($tanggalAwal);
        $end = Carbon::parse($tanggalAkhir);

        $tanggal_range = [];
        for($date = $start->copy(); $date->lte($end); $date->addDay()){  //lebih kecil sama dengan(lte).
            if(!$date->isWeekend()) {
                $tanggal_range[] = $date->format('Y-m-d');
            }
        }

        if(empty($tanggal_range)){
            return redirect()->back()->with('error', 'Tanggal yang dipilih tidak ada absensi.');
        }

        
        return Excel::download(new LaporanAbsensiExport($tanggal_range, $kelas_id), 'laporan_absensi.xlsx');
        // return view('data.excel_absensi_semester', compact('tanggal_range','kelas_id','siswa'));
    }

}