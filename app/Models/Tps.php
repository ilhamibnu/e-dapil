<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tps extends Model
{
    use HasFactory;
    protected $table = 'tb_tps';

    protected $fillable = [
        'name',
        'id_desa',
    ];

    public function detail_tps()
    {
        return $this->hasMany(DetailTps::class, 'id_tps', 'id');
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'id_desa', 'id');
    }

    public function relawan()
    {
        return $this->hasMany(Relawan::class, 'id_tps', 'id');
    }

}
