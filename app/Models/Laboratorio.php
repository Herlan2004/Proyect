<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratorio extends Model
{
    use HasFactory;
    protected $fillable = [
        "nombre",
    ];
    public function periodo()
    {
        return $this->hasMany(Periodo::class, 'laboratorio_id');
    }
}
