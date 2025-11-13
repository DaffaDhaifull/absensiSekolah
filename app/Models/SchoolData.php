<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolData extends Model
{
    use HasFactory;

    protected $table = 'school_data';

    protected $fillable = [
        'namaSekolah',
        'namaSingkat',
        'NPSN',
        'jenjang',
        'status',
        'telepon',
        'email',
        'kepalaSekolah',
        'logo',
        'alamat',
    ];
}
