<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKecamatan extends Model
{
    use HasFactory;

    protected $table = 'tb_detail_kecamatan';

    protected $fillable = [
        'id_kecamatan',
        'id_caleg',
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id');
    }

    public function detailDesa()
    {
        return $this->hasMany(DetailDesa::class, 'id_detail_kecamatan', 'id');
    }

    public function caleg()
    {
        return $this->belongsTo(Caleg::class, 'id_caleg', 'id');
    }
}
