<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'nis',
        'nama_siswa',
        'jenis_kelamin',
        'id_kelas',
        'telepon_ortu',
    ];
    
    protected $primaryKey = 'nis';

    public function classes(){
      return $this->belongsTo(Classes::class, 'id_kelas', 'id');
    }

    public function presence(){
      return $this->hasMany(Presence::class, 'nis', 'nis');
    }
}
