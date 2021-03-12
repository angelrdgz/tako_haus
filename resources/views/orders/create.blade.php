@extends('layouts.app')

@section('title')
Nueva Orden
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form method="post" action="{{ url('ordenes') }}">
                        @csrf
                        <input type="text" name="name" placeholder="¿Para quien es la cuenta?" class="form-control">
                        @error('name')
                        <p class="text-red-500 text-xs text-danger italic">{{ $message }}</p>
                        @enderror
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th style="width:170px;">Cantidad</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td price="{{ $product->price }}" class="price">{{ $product->name }}</td>
                                    <td style="display:flex; flex-direction: row; justify-content: space-around; align-content: center; align-items:center;">
                                        <a class="btn less">-</a>
                                        <input type="hidden" name="id[]" value="{{ $product->id }}">
                                        <input type="hidden" name="quantityItem[]" value="0">
                                        <span class="quantity">0</span>
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
                                    <td colspan="2" class="text-right"><b>Total</b></td>
                                    <td class="total text-right">0</td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="row">
                            <div class="col-sm-3 offset-sm-3">
                                <button type="submit" class="btn btn-primary btn-block">Guardar</button>
                            </div>
                            <div class="col-sm-3 ">
                                <a href="{{ url('ordenes') }}" class="btn btn-secondary btn-block">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {

        function calcTotal() {

            let subtotal = 0.0;

            for (let index = 0; index < $('.table tbody tr').length; index++) {
                if ($('.table tbody tr').eq(index).find('.subtotal').text() !== "") {
                    subtotal += parseFloat($('.table tbody tr').eq(index).find('.subtotal').text())
                }
            }

            $('.total').text(subtotal)

        }

        $(document).on('click', '.less', function() {
            let quantity = parseInt($(this).closest('td').find('.quantity').text());
            let price = parseInt($(this).closest('tr').find('.price').attr('price'));

            if (quantity > 0) {
                $(this).closest('td').find('.quantity').text(quantity - 1);
                $(this).closest('td').find('input[name="quantityItem[]"]').val(quantity - 1);
                $(this).closest('tr').find('.subtotal').text((quantity - 1) * price);
            }

            calcTotal();
        })

        $(document).on('click', '.more', function() {
            let quantity = parseInt($(this).closest('td').find('.quantity').text());
            let price = parseInt($(this).closest('tr').find('.price').attr('price'));
            $(this).closest('td').find('.quantity').text(quantity + 1);
            $(this).closest('td').find('input[name="quantityItem[]"]').val(quantity + 1);
            $(this).closest('tr').find('.subtotal').text((quantity + 1) * price);

            calcTotal();
        })

    })
</script>
@endsection