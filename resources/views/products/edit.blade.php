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
                                <label for="">Nombre</label>
                                <input name="name" type="text" value="{{ $product->name }}" class="form-control">
                                @error('nombre')
                                    <p class="text-red-500 text-xs text-danger italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <label for="">¿El producto cuenta con diferentes tamaños?</label>
                                <input type="checkbox" name="size" class="form-control"
                                    {{ $product->size ? 'checked' : '' }}>
                                @error('size')
                                    <p class="text-red-500 text-xs text-danger italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <label for="">¿El producto cuenta con diferentes tipos?</label>
                                <input type="checkbox" name="type" class="form-control"
                                    {{ $product->type ? 'checked' : '' }}>
                                @error('type')
                                    <p class="text-red-500 text-xs text-danger italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-sm-12">
                                <label for="">Descripción</label>
                                <input type="text" name="description" value="{{ $product->description }}"
                                    class="form-control">
                                @error('description')
                                    <p class="text-red-500 text-xs text-danger italic">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="row sizesPanel {{ $product->size ? '' : 'd-none' }}">
                            <div class="col-sm-12 mt-3">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <h4>Tamaños</h4>
                                    </div>
                                    <div class="col-sm-3">
                                        <a class="btn btn-link text-primary btn-block addRowSize">
                                            <i class="fas fa-plus"></i> Agregar Tamaño
                                        </a>
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Tamaño</th>
                                            <th>Precio</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($product->has('sizes'))
                                            @foreach ($product->sizes as $size)
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control" value="{{ $size->size }}"
                                                            readonly>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control number"
                                                            value="{{ $size->price }}" readonly>
                                                    </td>
                                                    <td>
                                                        <a class="text-primary confirmRow"><i
                                                                class="fas fa-check fa-lg"></i></a><a
                                                            class="text-primary editTypeRow"><i
                                                                class="fas fa-pencil-alt fa-lg"></i></a><a
                                                            class="text-primary removeRow ml-2"><i
                                                                class="fas fa-trash fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row typesPanel {{ $product->type ? '' : 'd-none' }}">
                            <div class="col-sm-12 mt-3">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <h4>Tipos</h4>
                                    </div>
                                </div>
                                <hr>
                                <div class="content w-100">
                                    <ul class="nav nav-tabs" role="tablist">
                                        @foreach ($product->sizes as $key => $size)
                                            <li>
                                                <a class="nav-link {{ $key == 0 ? 'active' : '' }}" aria-current="page"
                                                    data-toggle="tab" href="#sizeTab{{ $key + 1 }}"
                                                    role="tab">{{ $size->size }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content">
                                        @foreach ($product->sizes as $key => $size)
                                            <div class="tab-pane {{ $key == 0 ? 'active' : '' }}"
                                                id="sizeTab{{ $key + 1 }}" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <a class="btn btn-link text-primary addRowType float-right"
                                                            data-index="{{ $key }}">Agregar Tipo</a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Tipo</th>
                                                                    <th>Precio</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($size->types as $key2 => $val)
                                                                    <tr>
                                                                        <td>
                                                                            <input type="text" class="form-control"
                                                                                name="typeName{{ $key + 1 }}[]"
                                                                                value="{{ $val->name }}">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" class="form-control"
                                                                                name="typePrice{{ $key + 1 }}[]"
                                                                                value="{{ $val->price }}">
                                                                        </td>
                                                                        <td>
                                                                            <a class="text-primary confirmRow"><i
                                                                                    class="fas fa-check fa-lg"></i></a><a
                                                                                class="text-primary editTypeRow"><i
                                                                                    class="fas fa-pencil-alt fa-lg"></i></a><a
                                                                                class="text-primary removeRow ml-2"><i
                                                                                    class="fas fa-trash fa-lg"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
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
