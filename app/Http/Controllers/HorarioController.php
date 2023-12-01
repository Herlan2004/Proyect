<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Materia;
use App\Models\Periodo;
use App\Models\Semestre;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $horarios=Horario::orderBy("hora_inicio","asc")->get();
        return view("horarios.index", compact("horarios"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('horarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
        ]);
        horario::create($request->all());

        return redirect('horarios');
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
        $horario=horario::find($id);
        return view('horarios.create',compact('horario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
        ]);
        $horario=horario::find($id);
        $horario->fill($request->all());
        $horario->save();
        return redirect('horarios');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $horario=horario::find($id);
        if($horario){
            $horario->delete();
        }
        return redirect('horarios');
    }
}
