@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card shadow mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-10 pt-2">
                        <h5 class="m-0 font-weight-bold text-primary">Productos</h5>
                    </div>
                    <div class="col-sm-2">
                        <a href="{{ url('productos/create') }}" class="btn btn-link">
                            <i class="fas fa-plus"></i>
                            Nuevo Producto
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Tamaño</th>
                                <th>Tipo</th>
                                <th>Descripción</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->size }}</td>
                                <td>{{ $product->type }}</td>
                                <td>{{ $product->description }}</td>
                                <td>
                                    <a href="{{ url('productos/'.$product->id.'/edit')}}" class="btn btn-warning btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-pencil-alt"></i>
                                        </span>
                                        <span class="text">Modificar</span>
                                    </a>
                                    <form action="{{ route('productos.destroy',$product->id) }}" method="POST">
                    
                                        @csrf
                                        @method('DELETE')
                    
                                        <button type="submit" class="btn btn-danger">Delete</button>
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
@stop

@section('script')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@stop