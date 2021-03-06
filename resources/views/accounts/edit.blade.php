@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Modificar Cuenta</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form method="post" action="{{ route('cuentas.update', $account->id) }}">
                        @method('PATCH')
                        @csrf
                        <div class="row">
                            <div class="col-sm-9">
                                <input type="text" name="name" value="{{ $account->name}}" placeholder="¿Para quien es la cuenta?" class="form-control">
                                @error('name')
                                <p class="text-red-500 text-xs text-danger italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-sm-3 text-center">
                                <a class="btn btn-primary addDish">Agregar Plato</a>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="accordion">
                                    <?php $x = 1; ?>
                                    @foreach($account->orders as $order)
                                    <div class="card mb-2">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-sm-10">
                                                <a class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$x}}" aria-expanded="true" aria-control="collapse' + id + '">Plato #{{$x}} </a>
                                                <p class="pd-4">
                                                    @foreach($order->productsList as $product)
                                                     {{$product->quantity.' '.$product->product->name}}, 
                                                    @endforeach
                                                </p>
                                                </div>
                                                <div class="col-sm-2">
                                                    <h5 class="text-center">${{ $order->total($order->id) }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="collapse{{$x}}" class="collapse" data-parent="#accordion">
                                            <div class="card-body">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Producto</th>
                                                            <th style="width:170px;">Cantidad</th>
                                                            <th>Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($order->products as $product)
                                                        <tr>
                                                            <td price="{{ $product->product->price }}" class="price">{{ $product->product->name }}</td>
                                                            <td style="display:flex; flex-direction: row; justify-content: space-around; align-content: center; align-items:center;">
                                                                <a class="btn less">-</a>
                                                                <input type="hidden" name="id-{{$x}}[]" value="{{ $product->product_id }}">
                                                                <input type="hidden" name="quantityItem-{{$x}}[]" value="{{ $product->quantity }}">
                                                                <span class="quantity">{{ $product->quantity }}</span>
                                                                <a class="btn more">+</a>
                                                            </td>
                                                            <td class="text-right">
                                                                <span class="subtotal">0</span>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="2" class="text-right">
                                                                <b>Total</b>
                                                            </td>
                                                            <td class="total text-right">0</td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <?php $x++; ?>
                                        </div>
                                        @endforeach                                    
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3 offset-sm-3">
                                <button type="submit" class="btn btn-primary btn-block">Guardar</button>
                            </div>
                            <div class="col-sm-3 ">
                                <a href="{{ url('cuentas') }}" class="btn btn-secondary btn-block">Cancelar</a>
                            </div>
                        </div>
                    </form>
                    <br>
                    <div class="row">
                        <div class="col-sm-6 offset-sm-3">
                            <form method="post" action="{{ route('cuentas.destroy', $account->id) }}">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-block btn-danger">Cancelar Cuenta</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let tableProducts = '<table class="table"><thead><tr><th>Producto</th><th style="width:170px;">Cantidad</th><th>Subtotal</th></tr></thead><tbody>';

    @foreach($products as $product)
    tableProducts += '<tr>' +
        '<td price="{{ $product->price }}" class="price">{{ $product->name }}</td>' +
        '<td style="display:flex; flex-direction: row; justify-content: space-around; align-content: center; align-items:center;">' +
        '<a class="btn less">-</a>' +
        '<input type="hidden" name="id[]" value="{{ $product->id }}">' +
        '<input type="hidden" name="quantityItem[]" value="0">' +
        '<span class="quantity">0</span>' +
        '<a class="btn more">+</a>' +
        '</td>' +
        '<td class="text-right">' +
        '<span class="subtotal">0</span>' +
        '</td>' +
        '</tr>';

    @endforeach

    tableProducts += '</tbody><tfoot><tr><td colspan="2" class="text-right"><b>Total</b></td><td class="total text-right">0</td></tr></tfoot></table>';


    $(document).ready(function() {


        function drawCollapse(id) {

            let newAccordion = '<div class="card mb-2">' +
                '<div class="card-header">' +
                '<h5 class="mb-0"></h5>' +
                '<a class="btn btn-link" data-toggle="collapse" data-target="#collapse' + id + '" aria-expanded="true" aria-control="collapse' + id + '">Plato #' + id + '</a>' +
                '</div>' +
                '<div id="collapse' + id + '" class="collapse show" data-parent="#accordion">' +
                '<div class="card-body">' +
                '<table class="table">' +
                '<thead>' +
                '<tr>' +
                '<th>Producto</th>' +
                '<th style="width:170px;">Cantidad</th>' +
                '<th>Subtotal</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>';

            @foreach($products as $product)
            newAccordion += '<tr>' +
                '<td price="{{ $product->price }}" class="price">{{ $product->name }}</td>' +
                '<td style="display:flex; flex-direction: row; justify-content: space-around; align-content: center; align-items:center;">' +
                '<a class="btn less">-</a>' +
                '<input type="hidden" name="id-' + id + '[]" value="{{ $product->id }}">' +
                '<input type="hidden" name="quantityItem-' + id + '[]" value="0">' +
                '<span class="quantity">0</span>' +
                '<a class="btn more">+</a>' +
                '</td>' +
                '<td class="text-right">' +
                '<span class="subtotal">0</span>' +
                '</td>' +
                '</tr>';

            @endforeach


            newAccordion += '</tbody>' +
                '<tfoot>' +
                '<tr>' +
                '<td colspan="2" class="text-right">' +
                '<b>Total</b>' +
                '</td>' +
                '<td class="total text-right">0</td>' +
                '</tr>' +
                '</tfoot>' +
                '</table>' +
                '</div>' +
                '</div>';
            $('#accordion').append(newAccordion)

        }

        function calcTotal(id) {

            let subtotal = 0.0;

            for (let index = 0; index < $('#accordion .card').eq(id).find('.table tbody tr').length; index++) {
                if ($('#accordion .card').eq(id).find('.table tbody tr').eq(index).find('.subtotal').text() !== "") {
                    subtotal += parseFloat($('#accordion .card').eq(id).find('.table tbody tr').eq(index).find('.subtotal').text())
                }
            }

            $('#accordion .card').eq(id).find('.total').text(subtotal)

        }

        $(document).on('click', '.addDish', function() {
            let accordionLength = $('#accordion .card').length;
            drawCollapse(accordionLength + 1);
        });

        $(document).on('click', '.less', function() {
            let id = $(this).closest('#accordion .card').index() + 1;

            let quantity = parseInt($(this).closest('td').find('.quantity').text());
            let price = parseInt($(this).closest('tr').find('.price').attr('price'));

            if (quantity > 0) {
                $(this).closest('td').find('.quantity').text(quantity - 1);
                $(this).closest('td').find('input[name="quantityItem-' + id + '[]"]').val(quantity - 1);
                $(this).closest('tr').find('.subtotal').text((quantity - 1) * price);
            }

            calcTotal($(this).closest('#accordion .card').index());
        })

        $(document).on('click', '.more', function() {

            let id = $(this).closest('#accordion .card').index() + 1;
            let quantity = parseInt($(this).closest('td').find('.quantity').text());
            let price = parseInt($(this).closest('tr').find('.price').attr('price'));
            $(this).closest('td').find('.quantity').text(quantity + 1);
            $(this).closest('td').find('input[name="quantityItem-' + id + '[]"]').val(quantity + 1);
            $(this).closest('tr').find('.subtotal').text((quantity + 1) * price);

            calcTotal($(this).closest('#accordion .card').index());
        })

    })
</script>
@endsection