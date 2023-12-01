@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if (isset($docente))
                    <div class="card-header">Editar Docente:{{$docente->name}}</div>
                @else
                    <div class="card-header">Crear Docente</div>
                @endif
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (isset($docente))
                        <form method="POST" action="{{url('docentes/'.$docente->id)}}" enctype="multipart/form-data">
                    @else
                        <form method="POST" action="{{url('docentes')}}" enctype="multipart/form-data">
                    @endif
                        @if(isset($docente))
                            @method('PUT')
                        @endif
                        @csrf
                        <div>
                            <label>Nombre:</label>
                            <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{@$docente->nombre}}" required autocomplete="nombre" autofocus>
                        </div>
                        <div>
                            <label>Correo:</label>
                            <input type="email" class="form-control @error('nombre') is-invalid @enderror" name="correo" value="{{@$docente->correo}}">
                        </div>
                        <div>
                            <label>Telefono:</label>
                            <input type="number" class="form-control @error('nombre') is-invalid @enderror" name="telefono" value="{{@$docente->telefono}}">
                        </div>
                       <div>
                            <label for="foto">Selecciona una imagen:</label>
                            <br>
                            <input type="file" name="foto" id="foto" value="{{@$docente->foto}}" accept="image">
                        </div>
                        <br>
                        <!--<div class="form-group">
                            <label for="foto">Fotografía:</label>
                            <input type="file" name="foto" id="foto" value="{{@$docente->foto}}" required>
                        </div>-->
                        @if (isset($docente))
                            
                            <button type="submit" class="btn btn-success" name="botonsito">Editar</button>
                        @else
                            <button type="submit" class="btn btn-success" name="botonsito">Crear</button>
                            
                        @endif
                        <a href="{{ url('docentes') }}" class="btn btn-primary" >Atras</a>
                    </form>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
