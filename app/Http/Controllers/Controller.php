<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    /*public function __construct()
    {
        View::share('carreras', Carrera::all());
        //dd('carreras', Carrera::all());// Ajusta esto según tu lógica
    }*/
}
