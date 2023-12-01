@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Horarios</div>
                <div>
                    <a href="{{url('horarios/create')}}">
                        <button class="btn btn-success">Crear horario</button>
                    </a>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class='table'>
                        <thead>
                            <td>Hora de inicio</td>
                            <td>Hora de salida</td>
                            <td>Acciones</td>
                        </thead>
                        
                        <tbody>
                            
                            @foreach($horarios as $horario)
                            <tr>
                                <td>{{$horario->hora_inicio}}</td>
                                <td>{{$horario->hora_fin}}</td>
                                <td>
                                    <a class="btn btn-warning" href="{{url('horarios/'.$horario->id.'/edit')}}">Editar</a>
                                    <form action="{{ url('horarios/'.$horario->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este horario?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
