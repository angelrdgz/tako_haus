@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card shadow mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-12 pt-2">
                        <h5 class="m-0 font-weight-bold text-primary">Nuevo Producto</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="post" action="{{ url('productos') }}">
                    @csrf
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="">Nombre</label>
                            <input name="nombre" type="text" class="form-control">
                            @error('nombre')
                            <p class="text-red-500 text-xs text-danger italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-4">
                            <label for="">Precio</label>
                            <input type="text" name="price" class="form-control number">
                            @error('price')
                            <p class="text-red-500 text-xs text-danger italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-4">
                            <label for="">Descripción</label>
                            <input type="text" name="description" class="form-control">
                            @error('description')
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
                            <a href="{{ url('productos') }}" class="btn btn-secondary btn-block">Cancelar</a>
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