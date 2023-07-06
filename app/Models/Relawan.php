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
    ];

    public function detailRelawan()
    {
        return $this->hasMany(DetailRelawan::class, 'id_relawan', 'id');
    }
}
