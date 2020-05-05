@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card shadow mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-10 pt-2">
                        <h5 class="m-0 font-weight-bold text-primary">Modificar Producto</h5>
                    </div>
                    <div class="col-sm-2">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('productos.update', $product->id) }}">
                    @method('PATCH')
                    @csrf
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Nombre</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $product->name }}">
                                @error('name')
                                <p class="text-red-500 text-xs text-danger italic">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Precio</label>
                                <input type="text" name="price" class="form-control number @error('price') is-invalid @enderror" value="{{ $product->price }}">
                                @error('price')
                                <p class="text-red-500 text-xs text-danger italic">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Descripción</label>
                                <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ $product->description }}">
                                @error('description')
                                <p class="text-red-500 text-xs text-danger italic">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
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