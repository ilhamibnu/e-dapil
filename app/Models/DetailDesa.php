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
        'id_caleg',
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'id_desa', 'id');
    }

    public function detailTps()
    {
        return $this->hasMany(DetailTps::class, 'id_detail_desa', 'id');
    }

    public function caleg()
    {
        return $this->belongsTo(Caleg::class, 'id_caleg', 'id');
    }

}
