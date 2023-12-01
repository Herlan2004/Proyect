@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if (isset($user))
                    <div class="card-header">Editar usuario:{{$user->name}}</div>
                @else
                    <div class="card-header">Crear usuario</div>
                @endif
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (isset($user))
                        <form method="POST" action="{{url('users/'.$user->id)}}">
                    @else
                        <form method="POST" action="{{url('users')}}">
                    @endif
                        @if(isset($user))
                            @method('PUT')
                        @endif
                        @csrf
                        <div>
                            <label>Nombre:</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{@$user->name}}" required autocomplete="name" autofocus>
                        </div>
                        <div>
                            <label>Email:</label>
                            <input id="email" type="email" class="form-control @error('name') is-invalid @enderror" name="email" value="{{@$user->email}}" required autocomplete="email">
                        </div>
                        <div>
                            <label>Password:</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                            <div>
                                <label>Confirmar Password:</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        
                        <div>
                            <label >Rol</label>
                            <select id="rol_id" class="form-control @error('rol_id') is-invalid @enderror" name="rol_id" required >
                                <option value="">Select a Rol</option>
                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->id }}"
                                    @if ($rol->id == @$user->rol_id) selected @endif>{{ $rol->nombre }}</option>
                                @endforeach
                            </select>
                            @error('rol_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div><br>
                        @if (isset($user))
                         
                                <!--<input type="submit" name="botonsito" value="Editar">-->
                        <button type="submit" class="btn btn-success" name="botonsito">Editar</button>
                        
                        @else
                        
                        <button type="submit" class="btn btn-success" name="botonsito">Crear</button>
                        
                        @endif
                        
                        <a href="{{ url('users') }}" class="btn btn-primary" >Atras</a>
                    </form>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
