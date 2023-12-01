@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Laboratorios</div>
                <div>
                    <a href="{{url('laboratorios/create')}}">
                        <button class="btn btn-success">Crear Laboratorio</button>
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
                            <td>Nombre</td>
                            <td>Acciones</td>
                        </thead>
                        
                        <tbody>
                            
                            @foreach($laboratorios as $laboratorio)
                            <tr>
                                <td>{{$laboratorio->nombre}}</td>
                                <td>
                                    <a href="{{ url('laboratorios/'.$laboratorio->id.'/horario') }}" class="btn btn-success" >Horario</a>
                                    <a class="btn btn-warning" href="{{url('laboratorios/'.$laboratorio->id.'/edit')}}">Editar</a>
                                    <form action="{{ url('laboratorios/'.$laboratorio->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este laboratorio?')">Eliminar</button>
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
