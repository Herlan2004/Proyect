<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laboratorio;
use App\Models\Horario;
use App\Models\Carrera;
use App\Models\Semestre;
use App\Models\Materia;
use App\Models\Periodo;
use Carbon\Carbon;

class LabHorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($laboratorio_id)
    {
        //
        $laboratorio=Laboratorio::find($laboratorio_id);
        $horarios= Horario::all();
        $horarios = $horarios->map(function ($horario) {
            $horaInicio = Carbon::parse($horario->hora_inicio)->format('H:i');
            $horaFin = Carbon::parse($horario->hora_fin)->format('H:i');
    
            $horario->hora_inicio = $horaInicio;
            $horario->hora_fin = $horaFin;
    
            return $horario;
        });
        $carreras = Carrera::all();
        $semestres = Semestre::all();
        $materias = Materia::all();
        $periodos = Periodo::all();
        return view('LabHorarios.index', compact('laboratorio','periodos','horarios','carreras', 'semestres', 'materias'));
    }
    public function carrera_buscar(Request $request){
        $semestres= Semestre::where('carrera_id',$request->carrera_id)->get();
        return $semestres;
    }

    public function semestre_buscar(Request $request){
        $materias= Materia::where('semestre_id',$request->semestre_id)->get();
        return $materias;
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
