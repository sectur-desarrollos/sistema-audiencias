@extends('admin.layout.general')

@section('contenido')
<div class="container mt-4">
    <h2>Editar Audiencia</h2>
    <form action="{{ route('audiences.update', $audience->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $audience->nombre }}" required>
        </div>
        <div class="mb-3">
            <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
            <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" value="{{ $audience->apellido_paterno }}" required>
        </div>
        <div class="mb-3">
            <label for="apellido_materno" class="form-label">Apellido Materno</label>
            <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" value="{{ $audience->apellido_materno }}">
        </div>
        <div class="mb-3">
            <label for="asunto" class="form-label">Asunto</label>
            <input type="text" class="form-control" id="asunto" name="asunto" value="{{ $audience->asunto }}" required>
        </div>
        <div class="mb-3">
            <label for="fecha_llegada" class="form-label">Fecha de Llegada</label>
            <input type="date" class="form-control" id="fecha_llegada" name="fecha_llegada" 
                value="{{ old('fecha_llegada', \Carbon\Carbon::parse($audience->fecha_llegada)->format('Y-m-d')) }}" required>
        </div>
        <div class="mb-3">
            <label for="hora_llegada" class="form-label">Hora de Llegada</label>
            <input 
                type="time" 
                class="form-control" 
                id="hora_llegada" 
                name="hora_llegada" 
                value="" 
                required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $audience->telefono }}" required>
        </div>
        <div class="mb-3">
            <label for="lugar_dependencia" class="form-label">Lugar/Dependencia</label>
            <input type="text" class="form-control" id="lugar_dependencia" name="lugar_dependencia" value="{{ $audience->lugar_dependencia }}" required>
        </div>
        <div class="mb-3">
            <label for="tipo_contacto" class="form-label">Tipo de Contacto</label>
            <select class="form-control" id="tipo_contacto" name="tipo_contacto" required>
                <option value="Presencial" {{ $audience->tipo_contacto == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                <option value="Teléfono" {{ $audience->tipo_contacto == 'Teléfono' ? 'selected' : '' }}>Teléfono</option>
                <option value="Correo" {{ $audience->tipo_contacto == 'Correo' ? 'selected' : '' }}>Correo</option>
                <option value="Otro" {{ $audience->tipo_contacto == 'Otro' ? 'selected' : '' }}>Otro</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="cargo" class="form-label">Cargo</label>
            <input type="text" class="form-control" id="cargo" name="cargo" value="{{ $audience->cargo }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
