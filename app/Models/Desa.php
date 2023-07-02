<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use HasFactory;
    
    protected $table = 'tb_desa';

    protected $fillable = [
        'name',
    ];

    public function detailDesa()
    {
        return $this->hasMany(DetailDesa::class, 'id_desa', 'id');
    }
}
