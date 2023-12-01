<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Semestre;
use Illuminate\Http\Request;

class SemestreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($carrera_id)
    {
        $carrera = Carrera::find($carrera_id);
        $semestres = Semestre::where('carrera_id', $carrera_id)->get();
        return view('semestres.index', compact('carrera', 'semestres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($carrera_id)
    {
        //
        $carrera = Carrera::find($carrera_id);

        return view('semestres.create', compact('carrera'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($carrera_id,Request $request)
    {
        //
        $request->validate([
            'nombre' => 'required',
        ]);
        $request['carrera_id'] = $carrera_id;
        Semestre::create($request->all());

        return redirect('carreras/'.$carrera_id.'/semestres');
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
    public function edit($carrera_id, string $id)
    {
        //
        $carrera = Carrera::find($carrera_id);
        $semestre = Semestre::find($id);

        return view('semestres.create', compact('carrera', 'semestre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($carrera_id, Request $request, string $id)
    {
        //
        $request->validate([
            'nombre' => 'required',
        ]);

        $semestre = Semestre::find($id);

        $semestre->fill($request->all());
        $semestre->save();

        return redirect('carreras/'.$carrera_id.'/semestres');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($carrera_id, string $id)
    {
        //
        $semestre=Semestre::find($id);
        if($semestre)
        {
            $semestre->delete();
        }
        return redirect('carreras/'.$carrera_id.'/semestres');
    }
}
