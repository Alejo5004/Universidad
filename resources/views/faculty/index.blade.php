@extends('layouts.app')
@section('content')
    <section class="container">
        <h1 class="text-center mt-5">Todos las Facultades</h1>
        <article class="my-3 text-center">

            <!-- Boton de Crear Campus -->
            <a class="btn btn-primary" onclick="ModalFaculty('Crear Facultad', '/facultades', '', '', '', 'Crear')">Crear Facultades</a>

            <div id="component"></div>
        </article>

        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Eliminar</th>
                </tr>
            </thead>
            <tbody class="tbody">
                @foreach ($faculties as $faculty)
                    <tr>
                        <th scope="row">{{$faculty->id_faculty}}</th>
                        <td>{{$faculty->faculty_name}}</td>
                        <td>{{$faculty->faculty_description}}</td>
                        <td>
                            <a class="btn btn-warning" 
                                onclick="ModalFaculty(
                                    'Actualizar Facultad',
                                    '/facultades/{{$faculty->id_faculty}}',
                                    'PUT',
                                    '{{$faculty->faculty_name}}',
                                    '{{$faculty->faculty_description}}',
                                    'Actualizar',
                                    )">
                                Editar
                            </a>
                        </td>
                        <td>
                            <form action="/facultades/{{$faculty->id_faculty}}" method="post">
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
                var dataFaculty_name = $('#faculty_name').val();
                var dataFaculty_description = $('#faculty_description').val();

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
                    data: {
                        faculty_name: dataFaculty_name,
                        faculty_description: dataFaculty_description,
                    },
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
                            Programa creado Correctamente
                        </div>
                    `);
                    $('#modal').modal('hide')
                    
                    if(sendMethod == 'Post'){
                        $('tbody').append(`
                        <tr>
                            <th scope="row">${res.id_faculty}</th>
                            <td>${res.faculty_name}</td>
                            <td>${res.faculty_description}</td>
                            <td>
                                <a class="btn btn-warning" 
                                    onclick="ModalFaculty(
                                        'Actualizar Programa',
                                        '/facultades/${res.id_faculty}',
                                        'PUT',
                                        '${res.faculty_name}',
                                        '${res.faculty_description}',
                                        'Actualizar',
                                        )">
                                    Editar
                                </a>
                            </td>
                            <td>
                                <form action="/facultades/${res.id_faculty}" method="post">
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
                            $.each( value, function( key,  faculty) {
                                $('tbody').append(`
                                <tr>
                                    <th scope="row">${faculty.id_faculty}</th>
                                    <td>${faculty.faculty_name}</td>
                                    <td>${faculty.faculty_description}</td>
                                    <td>
                                        <a class="btn btn-warning" 
                                            onclick="ModalFaculty(
                                                'Actualizar Programa',
                                                '/facultades/${faculty.id_faculty}',
                                                'PUT',
                                                '${faculty.faculty_name}',
                                                '${faculty.faculty_description}',
                                                'Actualizar',
                                                )">
                                            Editar
                                        </a>
                                    </td>
                                    <td>
                                        <form action="/facultades/${faculty.id_faculty}" method="post">
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
                    $('#faculty_name').val('');
                    $('#faculty_description').val('');
                })
            })
        };

        // Modal de edit y create
        function ModalFaculty(title, action, method, faculty_name, faculty_description, btn ){
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
                            <form id="form" action="${action}" method="post">
                                @csrf
                                @method('${method}')
                                <div class="modal-body">
                                    <div id="alert"></div>
                                    <div class="form-group">
                                        <label for="faculty_name">Nombre</label>
                                        <input type="text" class="form-control" id="faculty_name" name="faculty_name" required="true" value="${faculty_name}">
                                    </div>
                                    <div class="form-group">
                                        <label for="faculty_description">Descripción</label>
                                        <input type="text" class="form-control" id="faculty_description" name="faculty_description" required="true" value="${faculty_description}">
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