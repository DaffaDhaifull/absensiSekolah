<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Notification;
use App\Models\Presece;

class SendMessageController extends Controller
{
    public function kirimAbsen($nama, $nis, $phone, $tanggal)
    {
        $token = env('FONNTE_API_TOKEN');
        $tanggalFormat = date('d-m-Y', strtotime($tanggal));
        $message = "Asslamualaikum Bapak/Ibu, hari ini tanggal $tanggalFormat, $nama tidak hadir di sekolah. Mohon keterangannya.";


        if (empty($phone) || !preg_match('/^[0-9]{10,15}$/', $phone)) {
            Notification::create([
                'nis' => $nis,
                'nama_siswa' => $nama,
                'telepon_ortu' => $phone ?? '-',
                'pesan' => $message,
                'status' => 'gagal',
            ]);
            return [
                'success' => false,
                'msg' => "Nomor telepon orang tua tidak valid."
            ];
        }



        try {
            $response = Http::withHeaders([
                'Authorization' => $token
            ])->post('https://api.fonnte.com/send', [
                'target'  => $phone,
                'message' => $message,
            ]);

            $success = $response->successful();

            Notification::create([
                'nis' => $nis,
                'nama_siswa' => $nama,
                'telepon_ortu' => $phone,
                'pesan' => $message,
                'status' => $success ? 'terkirim' : 'gagal',
            ]);

             return [
                'success' => $success,
                'msg' => $success ? 'Pesan terkirim' : ($errorMessage ?? 'Gagal mengirim pesan')
            ];
        } catch (\Exception $e) {

            Notification::create([
                'nis' => $nis,
                'nama_siswa' => $nama,
                'telepon_ortu' => $phone,
                'pesan' => $message,
                'status' => 'gagal',
            ]);

            return [
                'success' => false,
                'msg' => "Gagal terhubung ke server Fonnte."
            ];
        }
    }
}
