<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
    ];
    public function semestre()
    {
        return $this->hasMany(Semestre::class, 'carrera_id');
    }
}
