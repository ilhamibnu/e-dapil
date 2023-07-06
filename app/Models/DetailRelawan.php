<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailRelawan extends Model
{
    use HasFactory;

    protected $table = 'tb_detail_relawan';

    protected $fillable = [
        'name',
        'alamat',
        'id_detail_tps',
        'id_relawan'
    ];

    public function detailTps()
    {
        return $this->belongsTo(DetailTps::class, 'id_detail_tps', 'id');
    }

    public function detailPemilih()
    {
        return $this->hasMany(DetailPemilih::class, 'id_detail_relawan', 'id');
    }

    public function relawan()
    {
        return $this->belongsTo(Relawan::class, 'id_relawan', 'id');
    }
}
