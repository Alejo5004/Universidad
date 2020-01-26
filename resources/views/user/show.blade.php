@extends('layouts.app')
@section('content')
    <section class="container">
        <h1 class="text-center my-5">Datos Personales</h1>
        <div id="alert"></div>
        <article class="col-md-8 offset-md-2">
            <form id="form" action="/usuarios/{{$user->slug}}">
                @csrf
                @method('PUT')
                    <div class="row">
                        <div id="alert" class="col-12"></div>
                        <div class="col-md-6">
                            <div class="from-group">
                                <label for="name">Nombre</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{$user->name}}" required="true" disabled="true">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="from-group">
                                <label for="lastname">Apellido</label>
                                <input type="text" name="lastname" id="lastname" class="form-control" value="{{$user->lastname}}" disabled="true">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="from-group">
                                <label for="city_residence">Ciudad de Residencia</label>
                                <input type="text" name="city_residence" id="city_residence" class="form-control" value="{{$user->city_residence}}" disabled="true">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="from-group">
                                <label for="hometown">Ciudad de Origen</label>
                                <input type="text" name="hometown" id="hometown" class="form-control" value="{{$user->hometown}}" disabled="true">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="from-group">
                                <label for="nationality">Nacionalidad</label>
                                <input type="text" name="nationality" id="nationality" class="form-control" value="{{$user->nationality}}" disabled="true">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="from-group">
                                <label for="email">E-mail</label>
                                <input type="text" name="email" id="email" class="form-control" value="{{$user->email}}" required="true" disabled="true">
                            </div>
                        </div>
                        <div class="col-md-6 selectProgram">
                            <label for="basic-url">Programa 1</label>
                            <div class="input-group">
                                <select name="fk_program1" id="fk_program1" class="custom-select" disabled="true">
                                    <option selected>Seleccione</option>
                                    @foreach ($programs as $program)
                                        <option value="{{$program->id_program}}" {{$program->id_program == $program1->id_program ? 'selected': ''}}>{{$program->program_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 selectProgram">
                            <label for="basic-url">Programa 2</label>
                            <div class="input-group">
                                <select name="fk_program2" id="fk_program2" class="custom-select" disabled="true">
                                    <option selected>Seleccione</option>
                                    @foreach ($programs as $program)
                                        <option value="{{$program->id_program}}" {{$program->id_program == $program2->id_program ? 'selected': ''}}>{{$program->program_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="from-group">
                                <label for="student_code">Codigo del Estudiante</label>
                                <input type="text" name="student_code" id="student_code" class="form-control" value="{{$user->student_code}}" required="true" disabled="true">
                            </div>
                        </div>
                        @if (Auth::user()->fk_role == 1)
                            <div class="col-md-6">
                                <label for="basic-url">Rol</label>
                                <div class="input-group">
                                    <select name="fk_role" id="fk_role" class="custom-select" disabled="true">
                                        @foreach ($roles as $role)
                                            <option value="{{$role->id_role}}" {{ $role->id_role == $user->fk_role ? 'selected' : '' }}>{{$role->role_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="col-12 text-center mt-3" id="btn-type">
                            <button type="button" class="btn-change btn btn-warning" onclick="btnChange()">Editar</button>
                        </div>
                    </div>
                </form>
        </article>
    </section>
@endsection
@section('script')
<script>
    // Cambioo de botones de editar pasan a actualizar y cancelar
    function btnChange(){
            $('input').attr('disabled', false);
            $('select').attr('disabled', false);
            $('#btn-type').empty().append(`
                <button class="btn-change btn btn-success" onclick="send()">Actualizar</button>
                <button class="btn-change btn btn-danger" onclick="btnEdit()">Cancelar</button>
            `);
            $('.inputProgram').css('display', 'none');
            $('.selectProgram').css('display', 'inline');
    }

    // cambia de los botones actualizar y cancelar a el boton edit
    function btnEdit(){
        $('input').attr('disabled', true);
        $('select').attr('disabled',true);
        $('#btn-type').empty().append(`
            <button type="button" class="btn-change btn btn-warning" onclick="btnChange()">Editar</button>
        `);
    }

    // Envio del formulario
    function send() {
        $('#form').submit(function(e){
            e.preventDefault();
            var dataName = $('#name').val();
            var dataLastname = $('#lastname').val();
            var dataStudent_code = $('#student_code').val();
            var dataCity_residence = $('#city_residence').val();
            var dataHometown = $('#hometown').val();
            var dataNationality = $('#nationality').val();
            var dataEmail = $('#email').val();
            var dataFk_program1 = $('#fk_program1').val();
            var dataFk_program2 = $('#fk_program2').val();
            var dataFk_role = $('#fk_role').val();

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
                    name: dataName,
                    lastname: dataLastname, 
                    student_code: dataStudent_code, 
                    city_residence: dataCity_residence, 
                    hometown: dataHometown, 
                    nationality: dataNationality, 
                    email: dataEmail,
                    fk_program1: dataFk_program1,
                    fk_program2: dataFk_program2,
                    fk_role: dataFk_role,
                },
                beforeSend: function(){
                    $('.change-btn').attr('disable', 'true').html(`
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    `);
                }
            })
            .done(function(res){
                $('#alert').append(`
                    <div class="alert alert-success" role="alert">
                        Datos Actualizados.
                    </div>
                `)
                
            })
            .fail(function(){
                $('#alert').append(`
                    <div class="alert alert-danger" role="alert">
                        A ocurrido un error.
                    </div>
                `)
            })
            .always(function(){
                btnEdit();
                setTimeout(function(){
                    $('#alert').empty();
                }, 1000)
            })
        })
    };
</script>
@endsection