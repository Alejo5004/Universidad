@extends('layouts.app')
@section('content')
    <section class="container">
        <h1 class="text-center mt-5">Todos los campus</h1>
        <article class="my-3 text-center">
            {{-- moda --}}
            <div id="component"></div>
        </article>

        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Código</th>
                    <th scope="col">Origen</th>
                    <th scope="col">Nacionalidad</th>
                    <th scope="col">Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th scope="row"> {{$user->user_name}} {{$user->lastname}}</th>
                        <td>{{$user->student_code}}</td>
                        <td>{{$user->city_residence}}</td>
                        <td>{{$user->hometown}}</td>
                        <td>{{$user->nationality}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            <a class="btn btn-warning" onclick="ModalCampus()">Editar</a>
                        </td>
                        <td>
                            <form action="/campus/{{$user->user_name}}" method="post">
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
                var data_nationality = $('#nationality').val('');
                var data_user_name = $('#user_name').val('');
                var data_lastname = $('#lastname').val('');
                var data_email = $('#email').val('');
                var data_student_code = $('#student_code').val('');
                var data_city_residence = $('#city_residence').val('');
                var data_hometown = $('#hometown').val('');

                var link = $('#form').attr('action');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: link,
                    method: 'PUT',
                    dataType: 'json',
                    data: {
                        data_nationality : nationality,
                        data_user_name : user_name,
                        data_lastname : lastname,
                        data_email : email,
                        data_student_code : student_code,
                        data_city_residence : city_residence,
                        data_hometown : hometown,
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
                .done(function(){
                    $('#alert').append(`
                        <div class="alert alert-success" role="alert">
                            Campus creado Correctamente <small>(Recarge la pagina)</small>
                        </div>
                    `);
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
                    }
                })
                .fail(function(){
                    $('#alert').append(`
                        <div class="alert alert-danger" role="alert">
                            A simple danger alert—check it out!
                        </div>
                    `)
                })
                .always(function(){
                    $('.btn-send').attr('disable', 'false').html('Actualizar');
                    $('#modal').modal('hide');
                    $('#nationality').val('');
                    $('#user_name').val('');
                    $('#lastname').val('');
                    $('#email').val('');
                    $('#student_code').val('');
                    $('#city_residence').val('');
                    $('#hometown').val('');
                })
            })
        };

        // Modal de edit y create
        function ModalCampus(slug, user_name, lastname, email, student_code, city_residence, hometown, nationality){
            $('#component').empty()
            $('#component').append(`
                <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal">Editando Usuario</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="form" action="/user/${slug}">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div id="alert"></div>
                                        <div class="form-group">
                                            <label for="user_name">Nombre</label>
                                            <input type="text" class="form-control" id="user_name" name="user_name" value="${user_name}">
                                        </div>
                                        <div class="form-group">
                                            <label for="lastname">Apellido</label>
                                            <input type="text" class="form-control" id="lastname" name="lastname" value="${lastname}">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">E-mail</label>
                                            <input type="text" class="form-control" id="email" name="email" value="${email}">
                                        </div>
                                        <div class="form-group">
                                            <label for="student_code">Código del Estudiante</label>
                                            <input type="text" class="form-control" id="student_code" name="student_code" value="${student_code}">
                                        </div>
                                        <div class="form-group">
                                            <label for="city_residence">Ciudad de Residencia</label>
                                            <input type="text" class="form-control" id="city_residence" name="city_residence" value="${city_residence}">
                                        </div>
                                        <div class="form-group">
                                            <label for="hometown">Ciudad de origen</label>
                                            <input type="text" class="form-control" id="hometown" name="hometown" value="${hometown}">
                                        </div>
                                        <div class="form-group">
                                            <label for="nationality">Nacionalidad</label>
                                            <input type="text" class="form-control" id="nationality" name="nationality" value="${nationality}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-success btn-send" onclick="send()">Actualizar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            `)
            $('#modal').modal('show')
        }
    </script>
@endsection