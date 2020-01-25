@extends('layouts.app')
@section('content')
    <section class="container">
        <h1 class="text-center mt-5">Todos los programas</h1>
        <article class="my-3 text-center">

            <!-- Boton de Crear Campus -->
            <a class="btn btn-primary" onclick="ModalProgram('Crear Programa', '/programas', '', '', 'Crear')">Crear Programas</a>

            <div id="component"></div>
        </article>

        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Modalidad</th>
                    <th scope="col">Estatus</th>
                    <th scope="col">Facultad</th>
                    <th scope="col">Campus</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Eliminar</th>
                </tr>
            </thead>
            <tbody class="tbody">
                @foreach ($programs as $program)
                    <tr>
                        <th scope="row">{{$program->id_program}}</th>
                        <td>{{$program->program_name}}</td>
                        <td>{{$program->modality}}</td>
                        <td>{{$program->status}}</td>
                        <td>{{$program->faculty_name}}</td>
                        <td>{{$program->campus_name}}</td>
                        <td>
                            <a class="btn btn-warning" 
                                onclick="ModalProgram(
                                    'Actualizar Programa',
                                    '/programas/{{$program->id_program}}',
                                    'PUT',
                                    '{{$program->program_name}}',
                                    '{{$program->modality}}',
                                    '{{$program->status}}',
                                    '{{$program->id_faculty}}',
                                    '{{$program->id}}',
                                    'Actualizar',
                                    )">
                                Editar
                            </a>
                        </td>
                        <td>
                            <form action="/programas/{{$program->id_program}}" method="post">
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
                var dataProgram_name = $('#program_name').val();
                var dataModality = $('#modality').val();
                var dataStatus = $('#status').val();
                var dataFk_faculty = $('#fk_faculty').val();
                var dataFk_campus = $('#fk_campus').val();

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
                        program_name: dataProgram_name,
                        modality: dataModality, 
                        status: dataStatus, 
                        fk_faculty: dataFk_faculty, 
                        fk_campus: dataFk_campus,
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
                            <th scope="row">${res.id_program}</th>
                            <td>${res.program_name}</td>
                            <td>${res.modality}</td>
                            <td>${res.status}</td>
                            <td>${res.faculty_name}</td>
                            <td>${res.campus_name}</td>
                            <td>
                                <a class="btn btn-warning">
                                    Editar
                                </a>
                            </td>
                            <td>
                                
                                <form action="/programas/${res.id_program}" method="post">
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
                            $.each( value, function( key,  program) {
                                $('tbody').append(`
                                <tr>
                                    <th scope="row">${program.id_program}</th>
                                    <td>${program.program_name}</td>
                                    <td>${program.modality}</td>
                                    <td>${program.status}</td>
                                    <td>${program.faculty_name}</td>
                                    <td>${program.campus_name}</td>
                                    <td>
                                        <a class="btn btn-warning" 
                                            onclick="ModalProgram(
                                                'Actualizar Programa',
                                                '/programas/${program.id_program}',
                                                'PUT',
                                                '${program.program_name}',
                                                '${program.modality}',
                                                '${program.status}',
                                                '${program.id_faculty}',
                                                '${program.id}',
                                                'Actualizar',
                                                )">
                                            Editar
                                        </a>
                                    </td>
                                    <td>
                                        <form action="/programas/${program.id_program}" method="post">
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
                    $('#program_name').val('');
                    $('#modality').val('');
                    $('#status').val('');
                    $('#fk_faculty').val('');
                    $('#fk_campus').val('');
                })
            })
        };

        // Modal de edit y create
        function ModalProgram(title, action, method, program_name, btn ){
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
                                        <label for="program_name">Nombre</label>
                                        <input type="text" class="form-control" id="program_name" name="program_name" required="true" value="${program_name}">
                                    </div>
                                    <div class="input-group mb-3">
                                        <select name="modality" id="modality" class="custom-select" required="true">
                                            <option selected>Selecciona una modalidad</option>
                                            <option value="Presencial" {{ $program->modality == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                                            <option value="Virtual" {{ $program->modality == 'Virtual' ? 'selected' : '' }}>Virtual</option>
                                        </select>
                                    </div>
                                    <div class="input-group mb-3">
                                        <select name="status" id="status" class="custom-select" required="true">
                                            <option selected>Selecciona una Estado</option>
                                            <option value="Activa" {{ $program->status == 'Activa' ? 'selected' : '' }}>Activa</option>
                                            <option value="Desactiva" {{ $program->status == 'Desactiva' ? 'selected' : '' }}>Desactiva</option>
                                        </select>
                                    </div>
                                    <div class="input-group mb-3">
                                        <select name="fk_faculty" id="fk_faculty" class="custom-select" required="true">
                                            <option selected>Selecciona una facultad</option>
                                            @foreach($faculties as $faculty)
                                                <option value="{{$faculty->id_faculty}}" {{ $faculty->id_faculty == $program->fk_faculty ? 'selected' : '' }}>{{$faculty->faculty_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-group mb-3">
                                        <select name="fk_campus" id="fk_campus" class="custom-select" required="true">
                                            <option selected>Selecciona un Campus</option>
                                            @foreach($campuses as $campus)
                                                <option value="{{$campus->id}}" {{ $campus->id == $program->fk_campus ? 'selected' : '' }}>{{$campus->campus_name}}</option>
                                            @endforeach
                                        </select>
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