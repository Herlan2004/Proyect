<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\User;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    //
    public function index()
    {
        //
        $docentes = Docente::with('user')->get();
        //dd($users);
        return view('docentes.index',compact('docentes')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('docentes.edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'email', 'max:255'],
            'telefono' => ['required'],
            'foto',
        ]);
        //Docente::create($request->all());
        $foto = $request->file('foto');
        $nombreArchivo = null;
        if ($foto) {
            $fotoPath = $foto->store('public/images/docentes');
            $nombreArchivo = basename($fotoPath);
        }
    // Crea un nuevo docente en la base de datos
        Docente::create([
            'nombre' => $request->input('nombre'),
            'correo' => $request->input('correo'),
            'telefono' => $request->input('telefono'),
            'foto' => $nombreArchivo, // Almacena la ruta de la imagen
              
        ]);
        return redirect('docentes');
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
        $docente=Docente::find($id);
        //dd($user);
        return view('docentes.edit', compact('docente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $docente=Docente::find($id);
        $docente->nombre = $request->input('nombre');
        $docente->correo = $request->input('correo');
        $docente->telefono = $request->input('telefono');

        // Verifica si se proporcionó una nueva imagen
        if ($request->hasFile('foto')) {
            // Almacena la nueva imagen y obtén su ruta
            $fotoPath = $request->file('foto')->store('public/images/docentes');

            // Elimina la parte 'public/' de la ruta
            $nombreArchivo = basename($fotoPath);

            // Actualiza la ruta de la imagen en la base de datos
            $docente->foto = $nombreArchivo;
        }

        $docente->save();
        return redirect('docentes');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
