@extends('layouts.app')
@section('content')
    <section class="container">
        <h1 class="text-center my-5">Todos las Facultades</h1>
        
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre y Apellido</th>
                    <th scope="col">Programa 1</th>
                    <th scope="col">Programa 2</th>
                    <th scope="col">Codigo de Estudiante</th>
                    <th scope="col">email</th>
                    <th scope="col">Facultad</th>
                    <th scope="col">Campus</th>
                    <th scope="col">Mas Información</th>
                    @if (Auth::user()->fk_role == 1)
                        <th scope="col">Rol</th>
                        <th scope="col">Eliminar</th>
                    @endif

                </tr>
            </thead>
            <tbody class="tbody">
                @foreach ($faculties as $faculty)
                    <tr>
                        <th scope="row">{{$faculty->id_faculty}}</th>
                        <td>{{$faculty->faculty_name}}</td>
                        <td>{{$faculty->faculty_description}}</td>
                        @if (Auth::user()->fk_role == 1)
                            <td>{{$faculty->faculty_description}}</td>
                            <td>
                                <form action="usuarios/{{$faculty->id_faculty}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-delete">Eliminar</button>
                                </form>
                            </td>
                        @endif
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
@endsection