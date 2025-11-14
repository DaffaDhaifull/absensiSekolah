<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\Presence;
use App\Models\Classes;
use App\Models\SchoolData;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class LaporanAbsensiExport implements FromView
{
    protected $tanggal_range;
    protected $kelas_id;

    public function __construct($tanggal_range, $kelas_id = null)
    {
        $this->tanggal_range = $tanggal_range;
        $this->kelas_id = $kelas_id;
    }

    public function view(): View
    {
        $siswa = Student::when($this->kelas_id, fn($q) => $q->where('id_kelas', $this->kelas_id))->get();
        $kelas = Classes::with('users')->where('id', $this->kelas_id)->first();
        $data = SchoolData::first();
        $sekolah = $data->namaSekolah;

        $absensi_raw = Presence::whereIn('tanggal', $this->tanggal_range)
            ->when($this->kelas_id, fn($q) => $q->whereHas('student', fn($q2) => $q2->where('id_kelas', $this->kelas_id)))
            ->get();

        $absensi = [];
        foreach ($siswa as $s) {
            $absensi[$s->nis] = [];
            foreach ($this->tanggal_range as $tgl) {
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

        $bulan = collect($this->tanggal_range)
            ->map(fn($tgl) => Carbon::parse($tgl)->format('Y-m'))
            ->unique()
            ->values();;

        $viewFile = $bulan->count() > 1
            ? 'data.excel_absensi_semester'
            : 'data.excel_absensi_bulanan';

        return view($viewFile, [
            'siswa' => $siswa,
            'absensi' => $absensi,
            'bulanTerpilih' => $bulan,
            'tanggal_range' => $this->tanggal_range,
            'kelas'=> $kelas,
            'sekolah' => $sekolah,
        ]);
    }
}
