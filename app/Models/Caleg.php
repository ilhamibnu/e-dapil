<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caleg extends Model
{
    use HasFactory;
    protected $table = 'tb_caleg';

    protected $fillable = [
        'name',
        'no_urut',
        'foto',
    ];

    public function detailDesa()
    {
        return $this->hasMany(DetailDesa::class, 'id_caleg', 'id');
    }

    public function detailTps()
    {
        return $this->hasMany(DetailTps::class, 'id_caleg', 'id');
    }

    public function detailRelawan()
    {
        return $this->hasMany(DetailRelawan::class, 'id_caleg', 'id');
    }

    public function suara()
    {
        return $this->hasMany(Suara::class, 'id_caleg', 'id');
    }
}
