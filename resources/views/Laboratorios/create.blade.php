@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                    @if(isset($laboratorio))
                    <div class="card-header" >{{ $laboratorio->nombre }} - Editar laboratorio {{ $laboratorio->id }}</div>
                    <form action="{{ url('laboratorios/'.$laboratorio->id) }}" method="POST">
                    @else

                    <div class="card-header" >Crear laboratorio</div>
                    <form action="{{ url('laboratorios') }}" method="POST">

                    @endif
                    <div class="card-body" >

                        @if(isset($laboratorio))
                            @method('PUT')
                        @endif
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" name="nombre" class="form-control" value="{{ @$laboratorio->nombre }}">
                        </div>
                        <br>
                        @if(isset($laboratorio))
                        <button type="submit" class="btn btn-primary" >Editar</button>
                        @else
                        <button type="submit" class="btn btn-primary" >Crear</button>
                        @endif
                        <a href="{{ url('laboratorios') }}" class="btn btn-primary" >Atras</a>
                    </div>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection