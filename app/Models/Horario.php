<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;
    protected $fillable = [
        'hora_inicio',
        'hora_fin',
    ];
    public function semestre()
    {
        return $this->belongsTo(Semestre::class, 'semestre_id');
    }
    public function periodo()
    {
        return $this->hasMany(Periodo::class, 'horario_id');
    }
}
