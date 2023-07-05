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

    public function detailkecamatan(){
        return $this->hasMany(DetailKecamatan::class, 'id_caleg', 'id');
    }

}
