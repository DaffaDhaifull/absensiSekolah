<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index(Request $request){
         $adaFilter = $request->filled('tanggal_awal') || $request->filled('tanggal_akhir');

        if ($adaFilter) {
            $tanggalAwal  = $request->input('tanggal_awal', date('Y-m-d'));
            $tanggalAkhir = $request->input('tanggal_akhir', date('Y-m-d'));

            $data = Notification::whereDate('created_at', '>=', $tanggalAwal)
                    ->whereDate('created_at', '<=', $tanggalAkhir)
                    ->latest()
                    ->paginate(20)
                    ->withQueryString();
        } 
        else {
            $data = Notification::latest()->paginate(20);
        }

        return view('data.history_pesan', compact('data'));
    }
}
