@extends('layouts.app')
@section('content')
    <section class="container">
        <h1 class="text-center my-5">Todos los campus</h1>
        <article class="mb-5 text-center">

            <!-- Boton de Crear Campus -->
            <a class="btn btn-primary" onclick="ModalCampus('Crear Campus', 'Crear', '', '', '/campus', '')">Crear Campus</a>

            <div id="component"></div>
        </article>

        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Dirreccion</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Eliminar</th>
                </tr>
            </thead>
            <tbody class="tbody">
                @foreach ($campuses as $campus)
                    <tr>
                        <th scope="row"> {{$campus->id}}</th>
                        <td>{{$campus->campus_name}}</td>
                        <td>{{$campus->campus_address}}</td>
                        <td>
                            <a class="btn btn-warning" onclick="ModalCampus('Actualizar Campus', 'Actualizar', '{{$campus->campus_name}}', '{{$campus->campus_address}}', '/campus/{{$campus->id}}', 'PUT')">Editar</a>
                        </td>
                        <td>
                            <form action="/campus/{{$campus->id}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-delete">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endsection
@section('script')
    <script>
        // Eliminar un registro
        $(document).ready(function(){
            $('.btn-delete').click(function(e){
                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var row = $(this).parents('tr');
                var form = $(this).parents('form');
                var url = form.attr('action');

                $.post(url, form.serialize(), function(){
                    row.fadeOut();
                })
                .fail(function (){
                    console.log("Error");
                })
            })
        })
    </script>
    <script>
        // Envio de datos de los formularios 
        function send() {
            $('#form').submit(function(e){
                e.preventDefault();
                var dataName = $('#name').val();
                var dataAddress = $('#address').val();

                var sendMethod= $('input[name="_method"]').attr('value')
                if(sendMethod == ''){
                    sendMethod = 'Post'
                }
                var link = $('#form').attr('action');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: link,
                    method: sendMethod,
                    dataType: 'json',
                    data: {campus_name: dataName, campus_address: dataAddress},
                    beforeSend: function(){
                        $('.btn-send').attr('disable', 'true').html(`
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        `);
                        $('#alert').empty();
                    }
                })
                .done(function(res){
                    $('#alert').append(`
                        <div class="alert alert-success" role="alert">
                            Campus creado Correctamente <small>(Recarge la pagina)</small>
                        </div>
                    `);
                    $('#modal').modal('hide')
                    if(sendMethod =='Post'){
                        $('tbody').append(`
                            <tr>
                                <th scope="row">${res.id}</th>
                                <td>${res.name}</td>
                                <td>${res.address}</td>
                                <td>
                                    <a class="btn btn-warning" onclick="ModalCampus('Actualizar Campus', 'Actualizar', '${res.name}', '${res.address}', '/campus/${res.id}', 'PUT')">Editar</a>
                                </td>
                                <td>
                                    <form action="/campus/${res.id}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-delete">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        `)
                    }else{
                        $('tbody').empty();
                        $.each( res, function( key, value ) {
                            $.each( value, function( key, campus ) {
                                $('tbody').append(`
                                    <tr>
                                        <th scope="row">${campus.id}</th>
                                        <td>${campus.campus_name}</td>
                                        <td>${campus.campus_address}</td>
                                        <td>
                                            <a class="btn btn-warning" onclick="ModalCampus('Actualizar Campus', 'Actualizar', '${campus.campus_name}', '${campus.campus_address}', '/campus/${campus.id}', 'PUT')">Editar</a>
                                        </td>
                                        <td>
                                            <form action="/campus/${campus.id}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-delete">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                `)
                            });
                        });
                    }
                })
                .fail(function(){
                    $('#alert').append(`
                        <div class="alert alert-danger" role="alert">
                           A ocurrido un error.
                        </div>
                    `)
                })
                .always(function(){
                    $('.btn-send').attr('disable', 'false').html('Crear');
                    $('#name').val('');
                    $('#address').val('');
                    $('#alert').empty();
                })
            })
        };

        // Modal de edit y create
        function ModalCampus(title, btn, name, address, action, method){
            $('#component').empty()
            $('#component').append(`
                <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal">${title}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="form" action="${action}">
                                @csrf
                                @method('${method}')
                                <div class="modal-body">
                                    <div id="alert"></div>
                                    <div class="form-group">
                                        <label for="name">Nombre</label>
                                        <input type="text" class="form-control" id="name" name="name" value="${name}" required="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Dirección</label> 
                                        <input type="text" class="form-control" id="address" name="address" value="${address}" required="true">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success btn-send" onclick="send()">${btn}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            `)
            $('#modal').modal('show')
        }
    </script>
@endsection