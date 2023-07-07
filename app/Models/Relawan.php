<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relawan extends Model
{
    use HasFactory;
    protected $table = 'tb_relawan';

    protected $fillable = [
        'name',
        'alamat',
        'id_tps',
    ];

    public function detailRelawan()
    {
        return $this->hasMany(DetailRelawan::class, 'id_relawan', 'id');
    }

    public function tps()
    {
        return $this->belongsTo(Tps::class, 'id_tps', 'id');
    }
}
