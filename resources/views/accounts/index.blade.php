@extends('layouts.app')

@section('title')
Listado de Cuentas
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="card mt-3">

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
                                <th>Total</th>
                                <th colspan="2" class="text-right">
                                <a href="{{ url('cuentas/create') }}" class="btn btn-primary">Nueva Cuenta</a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($accounts as $account)
                            <tr>
                                <td>{{ $account->name }}</td>
                                <td>${{ number_format($account->total,2) }}</td>
                                <td>
                                    <a href="{{ url('cuentas/'.$account->id.'/edit') }}" class="btn btn-block btn-outline-primary">Modificar</a>
                                </td>
                                <td>
                                    <a accountId="{{ $account->id }}" total="{{ $account->total }}" class="btn btn-block btn-outline-primary cover">Cobrar</a>
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

@endsection

@section('scripts')
<script>
    var total = 0;
    var orderId = 0;

    $(document).on('keyup', '.payWith', function() {

        if ($(this).val() == '') {
            $('#coverModal .changeText').text('$0');
        } else {
            var pay = parseFloat($(this).val());
            $('#coverModal .changeText').text('$' + (pay - total));
        }
    })

    $(document).on('click', '.cover', function() {

        $('#coverModal .totalText').text('$' + $(this).attr('total'));

        total = parseFloat($(this).attr('total'))
        orderId = $(this).attr('accountId')

        $('#coverModal').modal({
            backdrop: 'static',
            keyboard: false
        });

    })

    $(document).on('click', '.coverBtn', function(){

        $.ajax({
            url: "{{ url('cuentas') }}"+"/"+orderId,
            type: "DELETE",
            async: true,
            dataType: "JSON",
            data:{
                _method: "DELETE",
                _token: "{{csrf_token()}}",
                id: orderId,
                order: true
            },
            success: function(data){
                console.log(data)
                window.location.reload();
            },
            error: function (error){
                console.log(error)
            }
        })

    })
</script>
@endsection