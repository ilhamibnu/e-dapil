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
        'nik',
        'alamat',
        'id_detail_relawan',
    ];

    public function detailRelawan()
    {
        return $this->belongsTo(DetailRelawan::class, 'id_detail_relawan', 'id');
    }


}
