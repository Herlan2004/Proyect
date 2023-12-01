<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre', 'semestre_id', 'docente_id'
    ];
    public function periodo()
    {
        return $this->hasMany(Periodo::class, 'materia_id');
    }
    public function semestre()
    {
        return $this->belongsTo(Semestre::class, 'semestre_id');
    }
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'docente_id');
    }
}
