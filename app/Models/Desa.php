<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use HasFactory;
    
    protected $table = 'tb_desa';

    protected $fillable = [
        'name',
        'id_kecamatan',
    ];

    public function detailDesa()
    {
        return $this->hasMany(DetailDesa::class, 'id_desa', 'id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id');
    }
}
