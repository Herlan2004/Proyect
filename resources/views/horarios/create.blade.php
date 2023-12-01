@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                    @if(isset($horario))
                    <div class="card-header" >{{ $horario->nombre }} - Editar horario {{ $horario->id }}</div>
                    <form action="{{ url('horarios/'.$horario->id) }}" method="POST">
                    @else

                    <div class="card-header" >Crear horario</div>
                    <form action="{{ url('horarios') }}" method="POST">

                    @endif
                    <div class="card-body" >

                        @if(isset($horario))
                            @method('PUT')
                        @endif
                        @csrf
                        <div class="form-group">
                            <label for="hora_inicio">Hora de inicio:</label>
                            <input type="time" name="hora_inicio" class="form-control" value="{{ @$horario->hora_inicio }}">
                        </div>
                        <div class="form-group">
                            <label for="hora_fin">Hora de salida:</label>
                            <input type="time" name="hora_fin" class="form-control" value="{{ @$horario->hora_fin }}">
                        </div>
                        <br>
                        @if(isset($horario))
                        <button type="submit" class="btn btn-primary" >Editar</button>
                        @else
                        <button type="submit" class="btn btn-primary" >Crear</button>
                        @endif
                        <a href="{{ url('horarios') }}" class="btn btn-primary" >Atras</a>
                    </div>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection