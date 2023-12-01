<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'carrera_id',
    ];
    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }
    public function horario()
    {
        return $this->hasMany(Horario::class, 'semestre_id');
    }
    public function materia()
    {
        return $this->hasMany(Materia::class, 'semestre_id');
    }
}
