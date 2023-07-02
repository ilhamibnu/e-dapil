<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPemilih extends Model
{
    use HasFactory;

    protected $table = 'tb_detail_pemilih';

    protected $fillable = [
        'name',
        'alamat',
        'id_detail_relawan',
        'id_caleg',
    ];

    public function detailRelawan()
    {
        return $this->belongsTo(DetailRelawan::class, 'id_detail_relawan', 'id');
    }

    public function caleg()
    {
        return $this->belongsTo(Caleg::class, 'id_caleg', 'id');
    }
    
}
