@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card shadow mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-10 pt-2">
                        <h5 class="m-0 font-weight-bold text-primary">Compras</h5>
                    </div>
                    <div class="col-sm-2">
                        <a href="{{ url('compras/create') }}" class="btn btn-link">
                            <i class="fas fa-plus"></i>
                            Nueva Compra
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
                                <th>Fecha y Hora</th>
                                <th>Total</th>
                                <th>Concepto</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchases as $purchase)
                            <tr>
                                <td>{{ $purchase->id }}</td>
                                <td>{{ date('d/m/Y H:i', strtotime($purchase->created_at)) }}</td>
                                <td>${{ number_format($purchase->total,2) }}</td>
                                <td>{{ $purchase->concept }}</td>
                                <td>
                                    <a href="{{ url('compras/'.$purchase->id.'/edit')}}" class="btn btn-warning btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-pencil-alt"></i>
                                        </span>
                                        <span class="text">Modificar</span>
                                    </a>
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