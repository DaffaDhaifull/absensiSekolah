<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'nis', 
        'nama_siswa', 
        'telepon_ortu', 
        'pesan', 
        'status'
    ];
}
