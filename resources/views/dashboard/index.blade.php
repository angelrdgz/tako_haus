@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-sm-6 col-lg-3">
            <div class="card-counter bg-primary">
                    <i class="fas fa-money-bill-wave"></i>
                    <span class="count-numbers">${{ number_format($dayTotal, 0) }}</span>
                    <span class="count-name text-white">Venta del Día</span>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card shadow mb-4">
                <div class="card-body">
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card shadow mb-4">
                <div class="card-body">
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card shadow mb-4">
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <div class="card shadow mb-4">
                <div class="card-body">
                </div>
            </div>

        </div>
        <div class="col-sm-4">
            <div class="card shadow mb-4">
                <div class="card-body">
                </div>
            </div>

        </div>
    </div>
@endsection
