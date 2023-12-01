<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Semestre;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $carreras=Carrera::get();
        return view('carreras.index', compact('carreras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('carreras.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nombre' => 'required',
        ]);
        Carrera::create($request->all());

        return redirect('carreras');
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
        $carrera=Carrera::find($id);
        return view('carreras.create',compact('carrera'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'nombre' => 'required',
        ]);
        $carrera=Carrera::find($id);
        $carrera->fill($request->all());
        $carrera->save();
        return redirect('carreras');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $carrera=Carrera::find($id);
        if($carrera){
            $carrera->delete();
        }
        return redirect('carreras');
    }
}
