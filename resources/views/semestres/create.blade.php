@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                    @if(isset($semestre))
                    <div class="card-header" >{{ $carrera->nombre }} - Editar semestre {{ $semestre->id }}</div>
                    <form action="{{ url('carreras/'.$carrera->id.'/semestres/'.$semestre->id) }}" method="POST">
                    @else

                    <div class="card-header" >{{ $carrera->nombre }} - Crear semestre</div>
                    <form action="{{ url('carreras/'.$carrera->id.'/semestres') }}" method="POST">

                    @endif
                    <div class="card-body" >

                        @if(isset($semestre))
                            @method('PUT')
                        @endif
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" name="nombre" class="form-control" value="{{ @$semestre->nombre }}">
                        </div>
                        <br>
                        @if(isset($semestre))
                        <button type="submit" class="btn btn-primary" >Editar</button>
                        @else
                        <button type="submit" class="btn btn-primary" >Crear</button>
                        @endif
                        <a href="{{ url('carreras/'.$carrera->id.'/semestres') }}" class="btn btn-primary" >Atras</a>
                    </div>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection