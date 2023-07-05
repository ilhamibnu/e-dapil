<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailDesa extends Model
{
    use HasFactory;
    protected $table = 'tb_detail_desa';

    protected $fillable = [
        'id_desa',
        'id_detail_kecamatan',
    ];



    public function desa()
    {
        return $this->belongsTo(Desa::class, 'id_desa', 'id');
    }

    public function detailKecamatan()
    {
        return $this->belongsTo(DetailKecamatan::class, 'id_detail_kecamatan', 'id');
    }

    public function detailTps()
    {
        return $this->hasMany(DetailTps::class, 'id_detail_desa', 'id');
    }

}
