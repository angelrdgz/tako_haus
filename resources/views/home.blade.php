@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-8">
                        Listado de Cuentas
                        </div>
                        <div class="col-sm-4">
                        <a href="{{ url('ordenes/create') }}" class="btn btn-block btn-link">Nueva Cuenta</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Cuenta</th>
                                <th># Produtos</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection