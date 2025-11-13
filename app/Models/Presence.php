<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;
    protected $fillable = [
        'nis',
        'tanggal',
        'keterangan',
        'id_guru',
    ];

    public function student() {
        return $this->belongsTo(Student::class, 'nis','nis');
    }
}
