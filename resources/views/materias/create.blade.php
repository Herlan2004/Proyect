@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                    @if(isset($materia))
                    <div class="card-header" >{{ $semestre->nombre }} - Editar materia {{ $materia->id }}</div>
                    <form action="{{ url('semestres/'.$semestre->id.'/materias/'.$materia->id) }}" method="POST">
                    @else
                    <div class="card-header" >{{ $semestre->nombre }} - Crear materia</div>
                    <form action="{{ url('semestres/'.$semestre->id.'/materias') }}" method="POST">

                    @endif
                    <div class="card-body" >

                        @if(isset($materia))
                            @method('PUT')
                        @endif
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" name="nombre" class="form-control" value="{{ @$materia->nombre }}">
                        </div>
                        <div class="form-group">
                            <label for="docente_id">Docente:</label>
                            <select name="docente_id" class="form-control">
                                <option value=" ">Ninguno</option>
                                @foreach($docentes as $docente)
                                    <option value="{{ @$docente->id }}"
                                        @if ($docente->id == @$materia->docente_id) selected @endif
                                        >{{@$docente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        @if(isset($materia))
                        <button type="submit" class="btn btn-primary" >Editar</button>
                        @else
                        <button type="submit" class="btn btn-primary" >Crear</button>
                        @endif
                        <a href="{{ url('semestres/'.$semestre->id.'/materias') }}" class="btn btn-primary" >Atras</a>
                    </div>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection