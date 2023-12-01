@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                    @if(isset($carrera))
                    <div class="card-header" >{{ $carrera->nombre }} - Editar carrera {{ $carrera->id }}</div>
                    <form action="{{ url('carreras/'.$carrera->id) }}" method="POST">
                    @else

                    <div class="card-header" >Crear carrera</div>
                    <form action="{{ url('carreras') }}" method="POST">

                    @endif
                    <div class="card-body" >

                        @if(isset($carrera))
                            @method('PUT')
                        @endif
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" name="nombre" class="form-control" value="{{ @$carrera->nombre }}">
                        </div>
                        <br>
                        @if(isset($carrera))
                        <button type="submit" class="btn btn-primary" >Editar</button>
                        @else
                        <button type="submit" class="btn btn-primary" >Crear</button>
                        @endif
                        <a href="{{ url('carreras') }}" class="btn btn-primary" >Atras</a>
                    </div>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection