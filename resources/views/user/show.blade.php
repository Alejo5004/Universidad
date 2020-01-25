@extends('layouts.app')
@section('content')
    <section class="container">
        <h1 class="text-center mt-5">Datos Personales</h1>
        <article class="col-md-8 offset-md-2">
            <div id="alert"></div>
            <article class="row">
                <form action="">
                    <div class="col-md-6">
                        <div class="from-group">
                            <label for="name">Nombre</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{$user->name}}" required="true">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="from-group">
                            <label for="lastname">Apellido</label>
                            <input type="text" name="lastname" id="lastname" class="form-control" value="{{$user->lastname}}" required="true">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="from-group">
                            <label for="student_code">Codigo del Estudiante</label>
                            <input type="text" name="student_code" id="student_code" class="form-control" value="{{$user->student_code}}" required="true">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="from-group">
                            <label for="city_residence">Ciudad de Residencia</label>
                            <input type="text" name="city_residence" id="city_residence" class="form-control" value="{{$user->city_residence}}" required="true">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="from-group">
                            <label for="hometown">Ciudad de Origen</label>
                            <input type="text" name="hometown" id="hometown" class="form-control" value="{{$user->hometown}}" required="true">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="from-group">
                            <label for="nationality">Nacionalidad</label>
                            <input type="text" name="nationality" id="nationality" class="form-control" value="{{$user->nationality}}" required="true">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="from-group">
                            <label for="email">E-mail</label>
                            <input type="text" name="email" id="email" class="form-control" value="{{$user->email}}" required="true">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="basic-url">Programa 1</label>
                        <div class="input-group">
                            <select name="fk_" id="fk_role" class="custom-select">
                                <option selected>Seleccione</option>
                                @foreach ($programs as $program)
                                    <option value="{{$program->id_faculty}}" {{ $user->fk_faculty == $program_user->id_faculty ? 'selected' : '' }}>{{$program->program_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="basic-url">Programa 2</label>
                        <div class="input-group">
                            <select name="fk_" id="fk_role" class="custom-select">
                                <option selected>Seleccione</option>
                                @foreach ($programs as $program)
                                    <option value="{{$program->id_faculty}}" {{ $user->fk_faculty == $program_user->id_faculty ? 'selected' : '' }}>{{$program->program_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <select name="fk_role" id="fk_role" class="custom-select">
                                @foreach ($roles as $role)
                                    <option value="{{$role->id_role}}" {{ $user->fk_role == $role->id_role ? 'selected' : '' }}>{{$role->role_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="from-group">
                            <label for="email">E-mail</label>
                            <input type="text" name="email" id="email" class="form-control" value="{{$user->email}}" required="true">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="input-group">
                            <select name="fk_" id="fk_role" class="custom-select">
                                @foreach ($faculties as $faculty)
                                    <option value="{{$faculty->id_faculty}}" {{ $user->fk_faculty == $faculty->id_faculty ? 'selected' : '' }}>{{$faculty->faculty_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <select name="fk_role" id="fk_role" class="custom-select">
                                @foreach ($campuses as $campus)
                                    <option value="{{$campus->id}}" {{ $user->fk_campus == $campus->id ? 'selected' : '' }}>{{$campus->campus_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn-send btn btn-success">Actualizar</button>
                    </div>
                </form>
            </article>
        </article>
    </section>
@endsection