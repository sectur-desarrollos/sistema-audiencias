@extends('admin.layout.general')

@section('contenido')
<div class="container mt-4">
    <a href="{{ route('audiences.create') }}" class="btn btn-primary mb-3">Nueva Audiencia</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Asunto</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($audiences as $audience)
            <tr>
                <td>{{ $audience->id }}</td>
                <td>{{ $audience->nombre }} {{ $audience->apellido_paterno }} {{ $audience->apellido_materno }}</td>
                <td>{{ $audience->asunto }}</td>
                <td>{{ $audience->fecha_llegada }}</td>
                <td>{{ $audience->hora_llegada }}</td>
                <td>
                    <a href="{{ route('audiences.edit', $audience) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('audiences.destroy', $audience) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta audiencia?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
