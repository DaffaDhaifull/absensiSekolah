<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_kelas',
        'wali_kelas',
    ];
    
    public function students(){
      return $this->hasMany(Classes::class);
    }

    public function users(){
      return $this->belongsTo(User::class, 'wali_kelas', 'id');
    }
}
