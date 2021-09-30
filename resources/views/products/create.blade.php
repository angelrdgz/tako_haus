@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-12 pt-2">
                            <h5 class="m-0 font-weight-bold text-primary">Nuevo Producto</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('productos') }}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="">Nombre</label>
                                <input name="name" type="text" class="form-control">
                                @error('nombre')
                                    <p class="text-red-500 text-xs text-danger italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <label for="">¿El producto cuenta con diferentes tamaños?</label>
                                <input type="checkbox" name="size" class="form-control">
                                @error('size')
                                    <p class="text-red-500 text-xs text-danger italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <label for="">¿El producto cuenta con diferentes tipos?</label>
                                <input type="checkbox" name="type" class="form-control">
                                @error('type')
                                    <p class="text-red-500 text-xs text-danger italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-sm-12">
                                <label for="">Descripción</label>
                                <input type="text" name="description" class="form-control">
                                @error('description')
                                    <p class="text-red-500 text-xs text-danger italic">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="row sizesPanel d-none">
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

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row typesPanel d-none">
                            <div class="col-sm-12 mt-3">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <h4>Tipos</h4>
                                    </div>
                                    <!--<div class="col-sm-3">
                                                <a class="btn btn-link text-primary btn-block addRowType"><i class="fas fa-plus"></i> Agregar
                                                    Tipo</a>
                                            </div>-->
                                </div>
                                <hr>
                                <div class="content w-100"></div>
                                <!--<table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Tipo</th>
                                                    <th>Precio</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>-->
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

@section('script')
    <script>
        var meats = [];

        @foreach($meats as $meat)
         meats = [...meats, {name: "{{$meat->name}}"}]
        @endforeach

        $(document).ready(function() {

            $(document).on('click', 'input[name="size"]', function() {
                $('.sizesPanel').toggleClass('d-none')
            })

            $(document).on('click', 'input[name="type"]', function() {
                let sizes = $('input[name="size"]').is(':checked') ? $('.sizesPanel table tbody tr')
                    .length : 1;

                let htmlSizes = '<ul class="nav nav-tabs" role="tablist">';
                for (let index = 0; index < sizes; index++) {
                    htmlSizes += '<li class="nav-item"><a class="nav-link ' + (index == 0 ? "active" : "") +
                        '" aria-current="page" data-toggle="tab" href="#sizeTab' + (index +
                            1) + '" role="tab">' + $(
                            '.sizesPanel table tbody tr:eq(' + index + ') input[name="sizeName[]"]').val() +
                        '</a></li>';
                }
                htmlSizes += '</ul><div class="tab-content" id="myTabContent">';
                for (let index = 0; index < sizes; index++) {
                    htmlSizes += '<div class="tab-pane fade ' + (index == 0 ? "show active" : "") +
                        '" id="sizeTab' + (index + 1) +
                        '" role="tabpanel" aria-labelledby="home-tab"><div class="row"><div class="col-sm-12"><a class="btn btn-link text-primary float-right addRowType" data-index="'+index+'">Agregar Tipo</a></div><hr></div><div class="row"><div class="col-sm-12"><table class="table"><thead><tr><th>Tipo</th><th>Precio</th><th></th></tr></thead><tbody>';
                     
                    meats.forEach((meat)=>{
                        htmlSizes += '<tr class="active"><td><input class="form-control" name="typeName'+(index+1)+'[]" value="'+meat.name+'" type="text" /></td><td><input type="text" name="typePrice'+(index+1)+'[]" value="0" class="form-control number"/></td><td class="text-center"><a class="text-primary confirmRow"><i class="fas fa-check fa-2x"/></a><a class="text-primary editTypeRow"><i class="fas fa-pencil-alt fa-2x"/></a><a class="text-primary removeRow ml-2"><i class="fas fa-trash fa-2x"></i></a></td></tr>';
                    })
                     htmlSizes += '</tbody></table></div></div></div>';
                }
                htmlSizes += '</div>';


                $('.typesPanel').toggleClass('d-none')
                $('.typesPanel .content').html(htmlSizes)
            })

            $(document).on('click', '.addRowSize', function() {
                if($('.sizesPanel .table tbody tr.active').length > 0){
                    return false;
                }

                let htmlRowSize =
                    '<tr class="active"><td><input class="form-control" name="sizeName[]" type="text" /></td><td><input type="text" name="sizePrice[]" value="0" class="form-control number"/></td><td class="text-center"><a class="text-primary confirmRow"><i class="fas fa-check fa-2x"/></a><a class="text-primary editSizeRow"><i class="fas fa-pencil-alt fa-2x"/></a><a class="text-primary removeRow ml-2"><i class="fas fa-trash fa-2x"></i></a></td></tr>';
                $('.sizesPanel .table tbody').append(htmlRowSize)
            })

            $(document).on('click', '.addRowType', function() {
                let index = $(this).data("index")
                if($('.typesPanel .table:eq('+index+') tbody tr.active').length > 0){
                    return false;
                }

                let htmlRowSize = '<tr class="active"><td><input class="form-control" name="typeName'+(index+1)+'[]" type="text" /></td><td><input type="text" name="typePrice'+(index+1)+'[]" value="0" class="form-control number"/></td><td class="text-center"><a class="text-primary confirmRow"><i class="fas fa-check fa-2x"/></a><a class="text-primary editTypeRow"><i class="fas fa-pencil-alt fa-2x"/></a><a class="text-primary removeRow ml-2"><i class="fas fa-trash fa-2x"></i></a></td></tr>';
                $('.typesPanel .table:eq('+index+') tbody').append(htmlRowSize)
            })

            $(document).on('click', '.sizesPanel .confirmRow', function() {
                let validate = true;
                $('.sizesPanel .active').find('input').each(function(input) {
                    if ($('.sizesPanel .active').find('input:eq(' + input + ')').val() == "") {
                        if (validate)
                            validate = false;

                        if (!$('.sizesPanel .active').find('input:eq(' + input + ')').hasClass('is-invalid'))
                            $('.sizesPanel .active').find('input:eq(' + input + ')').addClass('is-invalid')
                    } else {
                        if ($('.sizesPanel .active').find('input:eq(' + input + ')').hasClass('is-invalid'))
                            $('.sizesPanel .active').find('input:eq(' + input + ')').removeClass('is-invalid')

                    }
                })

                if (validate == true) {
                    $('.sizesPanel .active').find('input').attr('readonly', true);
                    $('.sizesPanel .active').removeClass('active')
                }
            })

            $(document).on('click', '.typesPanel .confirmRow', function() {
                let validate = true;
                $('.typesPanel .active').find('input').each(function(input) {
                    if ($('.typesPanel .active').find('input:eq(' + input + ')').val() == "") {
                        if (validate)
                            validate = false;

                        if (!$('.typesPanel .active').find('input:eq(' + input + ')').hasClass('is-invalid'))
                            $('.typesPanel .active').find('input:eq(' + input + ')').addClass('is-invalid')
                    } else {
                        if ($('.typesPanel .active').find('input:eq(' + input + ')').hasClass('is-invalid'))
                            $('.typesPanel .active').find('input:eq(' + input + ')').removeClass('is-invalid')

                    }
                })

                if (validate == true) {
                    $('.typesPanel .active').find('input').attr('readonly', true);
                    $('.typesPanel .active').removeClass('active')
                }
            })

            $(document).on('click', '.editSizeRow', function() {
                $(this).closest('tr').addClass('active')
                $('.active').find('input').attr('readonly', false);
            })

            $(document).on('click', '.editTypeRow', function() {
                $(this).closest('tr').addClass('active')
                $('.active').find('input').attr('readonly', false);
            })

            $(document).on('click', '.removeRow', function() {
                $(this).closest('tr').remove();
            })
        })

    </script>
@endsection
