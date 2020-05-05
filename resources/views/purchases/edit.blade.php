@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card shadow mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-10 pt-2">
                        <h5 class="m-0 font-weight-bold text-primary">Modificar Compra</h5>
                    </div>
                    <div class="col-sm-2">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('compras.update', $product->id) }}">
                    @method('PATCH')
                    @csrf
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Total</label>
                                <input type="text" name="total" class="form-control @error('total') is-invalid @enderror" value="{{ $product->total }}">
                                @error('total')
                                <p class="text-red-500 text-xs text-danger italic">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Concepto</label>
                                <input type="text" name="concept" class="form-control @error('concept') is-invalid @enderror" value="{{ $product->concept }}">
                                @error('concept')
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
                            <a href="{{ url('compras') }}" class="btn btn-secondary btn-block">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@stop