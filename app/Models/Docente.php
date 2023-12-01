<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
        'foto'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function materias()
    {
        return $this->hasMany(Materia::class, 'docente_id');
    }
}
