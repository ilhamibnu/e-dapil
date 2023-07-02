<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;
    protected $table = 'tb_kecamatan';

    protected $fillable = [
        'name',
    ];

    public function detailKecamatan()
    {
        return $this->hasMany(DetailKecamatan::class, 'id_kecamatan', 'id');
    }

    public function desa()
    {
        return $this->hasMany(Desa::class, 'id_kecamatan', 'id');
    }
}
