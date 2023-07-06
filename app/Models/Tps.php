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
    ];

    public function detail_tps()
    {
        return $this->hasMany(DetailTps::class, 'id_tps', 'id');
    }

}
