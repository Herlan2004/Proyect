<?php

namespace App\Http\Controllers;

use App\Models\Laboratorio;
use Illuminate\Http\Request;

class LaboratorioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $laboratorios = Laboratorio::all();
        return view("laboratorios.index", compact("laboratorios"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('laboratorios.create');
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
        laboratorio::create($request->all());

        return redirect('laboratorios');
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
        $laboratorio=laboratorio::find($id);
        return view('laboratorios.create',compact('laboratorio'));
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
        $laboratorio=laboratorio::find($id);
        $laboratorio->fill($request->all());
        $laboratorio->save();
        return redirect('laboratorios');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $laboratorio=laboratorio::find($id);
        if($laboratorio){
            $laboratorio->delete();
        }
        return redirect('laboratorios');
    }
}
