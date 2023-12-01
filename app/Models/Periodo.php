<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    use HasFactory;
    protected $fillable = [
        'dia',
        'materia_id',
        'horario_id',
        'laboratorio_id',
    ];
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }
    public function horario()
    {
        return $this->belongsTo(Horario::class, 'horario_id');
    }
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'laboratorio_id');
    }
}
