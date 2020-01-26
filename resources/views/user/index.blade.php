@extends('layouts.app')
@section('content')
    <section class="container">
        <h1 class="text-center my-5">Todos los Usuarios</h1>
        
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre y Apellido</th>
                    <th scope="col">Programa 1</th>
                    <th scope="col">Programa 2</th>
                    <th scope="col">Mas Información</th>
                    @if (Auth::user()->fk_role == 1)
                        <th scope="col">Eliminar</th>
                        <th scope="col">Rol</th>
                    @endif
                </tr>
            </thead>
            <tbody class="tbody">
                @php
                    $p1 = 0;
                    $p2 = 0;
                @endphp
                @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{$user->id}}</th>
                        <td>{{$user->name}} {{$user->lastname}}</td>
                        <td>
                            @while ($p1 < count($programs1))
                                @if($user->fk_program1 !== null)
                                    {{$programs1[$p1]->program_name}}
                                @else
                                    @php
                                        $p1 --;
                                    @endphp
                                @endif
                                @break
                            @endwhile
                        </td>
                        <td>
                            @while ($p2 < count($programs2))
                                @if($user->fk_program1 !== null)
                                    {{$programs2[$p2]->program_name}}
                                @else
                                    @php
                                        $p2 --;
                                    @endphp
                                @endif
                                @break
                            @endwhile
                        </td>
                        <td><a href="/usuarios/{{$user->slug}}" class="btn btn-info">Más Datos</a></td>
                        @if (Auth::user()->fk_role == 1)
                            <td>
                                <form action="/usuarios/{{$user->slug}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-delete">Eliminar</button>
                                </form>
                            </td>
                            <td>{{$user->role_name}}</td>
                        @endif
                    </tr>
                    @php
                        $p1 ++;
                        $p2 ++;
                    @endphp
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