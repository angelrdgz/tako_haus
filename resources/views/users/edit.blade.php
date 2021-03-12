@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card shadow mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-12 pt-2">
                        <h5 class="m-0 font-weight-bold text-primary">Nuevo Usuario</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
            <form method="post" action="{{ route('usuarios.update', $user->id) }}">
                    @method('PATCH')
                    @csrf
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="">Nombre</label>
                            <input name="name" type="text" value="{{ $user->name }}" class="form-control">
                            @error('name')
                            <p class="text-red-500 text-xs text-danger italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-4">
                            <label for="">Email</label>
                            <input name="email" type="email" value="{{ $user->email }}" class="form-control">
                            @error('email')
                            <p class="text-red-500 text-xs text-danger italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-4">
                            <label for="">Rol</label>
                            <select name="rol" id="" class="form-control">
                                <option value="">Seleccione un rol</option>
                                @foreach($roles as $rol)
                                <option value="{{ $rol->id }}" {{ $user->role_id == $rol->id ? 'selected':'' }}>{{ $rol->name }}</option>
                                @endforeach
                            </select>
                            @error('rol')
                            <p class="text-red-500 text-xs text-danger italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-4">
                            <label for="">Contraseña</label>
                            <input type="password" name="password" class="form-control">
                            @error('password')
                            <p class="text-red-500 text-xs text-danger italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3 offset-sm-3">
                            <button type="submit" class="btn btn-primary btn-block">Guardar</button>
                        </div>
                        <div class="col-sm-3 ">
                            <a href="{{ url('usuarios') }}" class="btn btn-secondary btn-block">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@stop

@section("script")
<script>
    
</script>
@endsection