<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\Semestre;
use Illuminate\Http\Request;
use App\Models\Docente;
class MateriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($semestre_id)
    {
        //
        $semestre = Semestre::find($semestre_id);
        $materias = Materia::where('semestre_id', $semestre_id)->get();
        return view('materias.index', compact('semestre', 'materias'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($semestre_id)
    {
        //
        $semestre = Semestre::find($semestre_id);
        $docentes = Docente::all();
        return view('materias.create', compact('semestre', 'docentes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($semestre_id, Request $request)
    {
        //
        $request->validate([
            'nombre' => 'required',
        ]);
        $request['semestre_id'] = $semestre_id;
        Materia::create($request->all());

        return redirect('semestres/'.$semestre_id.'/materias');
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
    public function edit($semestre_id, $id)
    {
        //
        $semestre = Semestre::find($semestre_id);
        $docentes = Docente::all();
        $materia = Materia::find($id);

        return view('materias.create', compact('semestre','docentes', 'materia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($semestre_id, Request $request, string $id)
    {
        //
        $request->validate([
            'nombre' => 'required',
            'docente_id',
        ]);

        $materia = Materia::find($id);
        $materia->fill($request->all());
        $materia->save();

        return redirect('semestres/'.$semestre_id.'/materias');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($semestre_id,string $id)
    {
        //
        $materia=Materia::find($id);
        if($materia){
            $materia->delete();
        }
        return redirect('semestres/'.$semestre_id.'/materias');
    }
}
