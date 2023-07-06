<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTps extends Model
{
    use HasFactory;

    protected $table = 'tb_detail_tps';

    protected $fillable = [
        'name',
        'id_detail_desa',
        'id_tps'
    ];

    public function detailDesa()
    {
        return $this->belongsTo(DetailDesa::class, 'id_detail_desa', 'id');
    }

    public function detailRelawan()
    {
        return $this->hasMany(DetailRelawan::class, 'id_detail_tps', 'id');
    }

    public function tps()
    {
        return $this->belongsTo(Tps::class, 'id_tps', 'id');
    }


}
