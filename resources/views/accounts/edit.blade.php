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
                            <input type="hidden" name="count" value="{{ $account->orders->count() }}">
                            <div class="row">
                                <div class="col-sm-9">
                                    <input type="text" name="name" value="{{ $account->name }}"
                                        placeholder="¿Para quien es la cuenta?" class="form-control">
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
                                        @foreach ($account->orders as $order)
                                            <div class="card mb-2">
                                                <div class="card-header">
                                                    <div class="row">
                                                        <div class="col-sm-8">
                                                            <a class="btn btn-link" data-toggle="collapse"
                                                                data-target="#collapse{{ $x }}"
                                                                aria-expanded="true"
                                                                aria-control="collapse{{ $x }}">Orden
                                                                #{{ $x }} </a>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="checkbox icheck-success">
                                                                <input type="checkbox"
                                                                    {{ $order->onion ? 'checked' : '' }}
                                                                    id="onion{{ $x }}" />
                                                                <input type="hidden" name="onion-{{ $x }}"
                                                                    value="{{ $order->onion }}" />
                                                                <label for="onion{{ $x }}">Cebolla</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="checkbox icheck-success">
                                                                <input type="checkbox"
                                                                    {{ $order->cilantro ? 'checked' : '' }}
                                                                    id="cilantro{{ $x }}" />
                                                                <input type="hidden" name="cilantro-{{ $x }}"
                                                                    value="{{ $order->cilantro }}" />
                                                                <label for="cilantro{{ $x }}">Cilantro</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="collapse{{ $x }}" class="collapse"
                                                    data-parent="#accordion">
                                                    <div class="card-body">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Producto</th>
                                                                    <th>Tamaño</th>
                                                                    <th>Tipo</th>
                                                                    <th style="width:170px;">Cantidad</th>
                                                                    <th>Subtotal</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $total = 0; ?> 
                                                                @foreach ($order->products as $orderProduct)
                                                                    <?php
                                                                    $sizes = App\ProductSize::where('product_id',
                                                                    $orderProduct->product_id)->get();
                                                                    $types = App\ProductType::where('product_id',
                                                                    $orderProduct->product_id)
                                                                    ->where('product_size_id',
                                                                    $orderProduct->product_size_id)
                                                                    ->get();
                                                                    ?>
                                                                    <tr>
                                                                        <td>
                                                                            <select class="form-control selectProduct"
                                                                                name="productId-{{ $x }}[]">
                                                                                <option value="">Seleccione producto
                                                                                </option>
                                                                                @foreach ($products as $product)
                                                                                    <option value="{{ $product->id }}"
                                                                                        {{ $product->id == $orderProduct->product_id ? 'selected' : '' }}>
                                                                                        {{ $product->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                        <td><select class="form-control selectSize"
                                                                                name="sizeId-{{ $x }}[]">
                                                                                <option value="">Seleccionar opción</option>
                                                                                @foreach ($sizes as $size)
                                                                                    <option value="{{ $size->id }}"
                                                                                        {{ $size->id == $orderProduct->product_size_id ? 'selected' : '' }}>
                                                                                        {{ $size->size }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                        <td><select class="form-control selectType"
                                                                                name="typeId-{{ $x }}[]">
                                                                                <option value="">Seleccionar opción</option>
                                                                                @foreach ($types as $type)
                                                                                    <option value="{{ $type->id }}"
                                                                                        {{ $type->id == $orderProduct->product_type_id ? 'selected' : '' }}>
                                                                                        {{ $type->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                        <td
                                                                            style="display:flex; flex-direction: row; justify-content: space-around; align-content: center; align-items:center;">
                                                                            <a class="btn less">-</a>
                                                                            <input type="hidden"
                                                                                name="id-{{ $x }}[]"
                                                                                value="{{ $orderProduct->product_id }}">
                                                                            <input type="hidden"
                                                                                name="quantityItem-{{ $x }}[]"
                                                                                value="{{ $orderProduct->quantity }}">
                                                                            <input type="hidden"
                                                                                name="priceItem-{{ $x }}[]"
                                                                                class="price"
                                                                                value="{{ $orderProduct->price }}">
                                                                            <span
                                                                                class="quantity">{{ $orderProduct->quantity }}</span>
                                                                            <a class="btn more">+</a>
                                                                        </td>
                                                                        <td class="text-right">
                                                                            <span class="subtotal">${{ ($orderProduct->quantity * $orderProduct->price) }}</span>
                                                                        </td>
                                                                    </tr>
                                                                    <?php $total += ($orderProduct->quantity * $orderProduct->price); ?>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="3" class="text-left">
                                                                        <a class="btn btn-link addProduct">Agregar
                                                                            producto</a>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <b>Total</b>
                                                                    </td>
                                                                    <td class="total text-right">${{ $total }}</td>
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
        
    $(document).ready(function() {

        $(document).on('change', 'input[type="checkbox"]', function(e) {
            if ($(this).prop('checked')) {
                $(this).next().val(1);
            } else {
                $(this).next().val(0);
            }
        });


        function drawCollapse(id) {

            let newAccordion = '<div class="card mb-2">' +
                '<div class="card-header">' +
                '<div class="row">' +
                '<div class="col-sm-8">' +
                '<a class="btn btn-link" data-toggle="collapse" data-target="#collapse' + id +
                '" aria-expanded="true" aria-control="collapse' + id + '">Orden #' + id + '</a>' +
                '</div>' +
                '<div class="col-sm-2">' +
                '<div class="checkbox icheck-success">' +
                '<input type="checkbox" checked id="onion' + id + '"/><input type="hidden" name="onion-' + id +
                '" value="1" />' +
                '<label for="onion' + id + '">Cebolla</label>' +
                '</div>' +
                '</div>' +
                '<div class="col-sm-2">' +
                '<div class="checkbox icheck-success">' +
                '<input type="checkbox" checked id="cilantro' + id +
                '" /><input type="hidden" name="cilantro-' + id + '" value="1" />' +
                '<label for="cilantro' + id + '">Cilantro</label>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div id="collapse' + id + '" class="collapse show" data-parent="#accordion">' +
                '<div class="card-body">' +
                '<table class="table">' +
                '<thead>' +
                '<tr>' +
                '<th>Producto</th>' +
                '<th>Tamaño</th>' +
                '<th>Tipo</th>' +
                '<th style="width:170px;">Cantidad</th>' +
                '<th>Subtotal</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>' +
                '<tr><td><select class="form-control selectProduct" name="productId-' + id + '[]"><option value="">Seleccione producto</option>';

            @foreach ($products as $product)
                newAccordion += '<option value="{{ $product->id }}">{{ $product->name }}</option>';                
            @endforeach


            newAccordion +=
                '</select></td><td><select class="form-control selectSize" name="sizeId-' + id + '[]"></select></td><td><select class="form-control selectType" name="typeId-' + id + '[]"></select></td>' +
                '<td style="display:flex; flex-direction: row; justify-content: space-around; align-content: center; align-items:center;">' +
                '<a class="btn less">-</a>' +
                '<input type="hidden" name="id-' + id + '[]" value="{{ $product->id }}">' +
                '<input type="hidden" name="quantityItem-' + id + '[]" value="1">' +
                '<input type="hidden" name="priceItem-' + id + '[]" class="price" value="0">' +
                '<span class="quantity">1</span>' +
                '<a class="btn more">+</a>' +
                '</td>' +
                '<td class="text-right">' +
                '<span class="subtotal">0</span>' +
                '</td>' +
                '</tr></tbody>' +
                '<tfoot>' +
                '<tr>' +
                    '<td colspan="3" class="text-left">' +
                '<a class="btn btn-link addProduct">Agregar producto</a>' +
                '</td>' +
                '<td class="text-right">' +
                '<b>Total</b>' +
                '</td>' +
                '<td class="total text-right">0</td>' +
                '</tr>' +
                '</tfoot>' +
                '</table>' +
                '</div>' +
                '</div>';
            $('#accordion').append(newAccordion)

            $('input[name="count"]').val(parseInt($('input[name="count"]').val())+1)

        }

        function calcTotal(id) {

            let subtotal = 0.0;

            for (let index = 0; index < $('#accordion .card').eq(id).find('.table tbody tr').length; index++) {
                if ($('#accordion .card').eq(id).find('.table tbody tr').eq(index).find('.subtotal').text() !==
                    "") {
                    subtotal += parseFloat($('#accordion .card').eq(id).find('.table tbody tr').eq(index).find(
                        '.subtotal').text().replace("$",""))
                }
            }

            $('#accordion .card').eq(id).find('.total').text("$"+subtotal)

        }

        $(document).on('click', '.addDish', function() {
            let accordionLength = $('#accordion .card').length;
            drawCollapse(accordionLength + 1);
        });

        $(document).on('click', '.addProduct',function(){
            let id = $(this).closest('#accordion .card').index() + 1;
            let table = $(this).closest('table');

            let newRow = '<tr><td><select class="form-control selectProduct" name="productId-' + id + '[]"><option value="">Seleccione producto</option>';
                @foreach ($products as $product)
                newRow += '<option value="{{ $product->id }}">{{ $product->name }}</option>';                
            @endforeach

            newRow +=
                '</select></td><td><select class="form-control selectSize" name="sizeId-' + id + '[]"></select></td><td><select class="form-control selectType" name="typeId-' + id + '[]"></select></td>' +
                '<td style="display:flex; flex-direction: row; justify-content: space-around; align-content: center; align-items:center;">' +
                '<a class="btn less">-</a>' +
                '<input type="hidden" name="quantityItem-' + id + '[]" value="1">' +
                '<input type="hidden" name="priceItem-' + id + '[]" class="price" value="0">' +
                '<span class="quantity">1</span>' +
                '<a class="btn more">+</a>' +
                '</td>' +
                '<td class="text-right">' +
                '<span class="subtotal">0</span>' +
                '</td>' +
                '</tr>';
            table.find('tbody').append(newRow);

        })

        $(document).on('change', '.selectProduct', function() {

            let productId = $(this).find('option:selected').val()

            let tr = $(this).closest('tr')

            $.ajax({
                url: "{{ url('/tamanos') }}/" + productId,
                type: "GET",
                async: true,
                success: function(data) {
                    let optionHtml = '<option value="">Seleccionar tamaño</option>';

                    data.sizes.forEach((size) => {
                        optionHtml +=
                            `<option value="${size.id}" data-price="${size.price}">${size.size}</option>`;
                    })

                    tr.find('.selectSize').append(optionHtml);
                }
            })
        })

        $(document).on('change', '.selectSize', function() {

            let sizeId = $(this).find('option:selected').val()
            let tr = $(this).closest('tr')
            let price = $(this).find('option:selected').data('price')
            let id = $(this).closest('#accordion .card').index() + 1;
            tr.find('input[name="priceItem-' + id + '[]"]').val(price)
            tr.find('.subtotal').text('$'+(price*parseInt(tr.find('.quantity').text())));

            tr.find('.selectType').empty()

            $.ajax({
                url: "{{ url('/tipos') }}/" + sizeId,
                type: "GET",
                async: true,
                success: function(data) {
                    let optionHtml = '<option value="">Seleccionar tipo</option>';

                    data.types.forEach((type) => {
                        optionHtml +=
                            `<option value="${type.id}" data-price="${type.price}">${type.name}</option>`;
                    })

                    tr.find('.selectType').append(optionHtml);
                }
            })

            calcTotal($(this).closest('#accordion .card').index());
        })

        $(document).on('change', '.selectType', function() {
            let price = $(this).find('option:selected').data('price')
            let tr = $(this).closest('tr')
            let id = $(this).closest('#accordion .card').index() + 1;
            tr.find('input[name="priceItem-' + id + '[]"]').val(price)
            tr.find('.subtotal').text('$'+(price*parseInt(tr.find('.quantity').text())));

            calcTotal($(this).closest('#accordion .card').index());
        })

        $(document).on('click', '.less', function() {
            let id = $(this).closest('#accordion .card').index() + 1;

            let quantity = parseInt($(this).closest('td').find('.quantity').text());
            let price = parseInt($(this).closest('tr').find('.price').val());

            if (quantity > 1) {
                $(this).closest('td').find('.quantity').text(quantity - 1);
                $(this).closest('td').find('input[name="quantityItem-' + id + '[]"]').val(quantity - 1);
                $(this).closest('tr').find('.subtotal').text("$"+((quantity - 1) * price));
            }

            calcTotal($(this).closest('#accordion .card').index());
        })

        $(document).on('click', '.more', function() {

            let id = $(this).closest('#accordion .card').index() + 1;
            let quantity = parseInt($(this).closest('td').find('.quantity').text());
            let price = $(this).closest('tr').find('.price').val();
            $(this).closest('td').find('.quantity').text(quantity + 1);
            $(this).closest('td').find('input[name="quantityItem-' + id + '[]"]').val(quantity + 1);
            $(this).closest('tr').find('.subtotal').text("$"+((quantity + 1) * price));

            calcTotal($(this).closest('#accordion .card').index());
        })

    })
</script>
@endsection
