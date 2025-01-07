@extends('admin.layout.general')

@section('nombre_seccion', 'Editar audiencia')

@section('contenido')
<div class="container mt-4">
    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card shadow-lg border-secondary">
        <div class="card-body">
            <form action="{{ route('audiences.update', $audience->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <!-- Nombre -->
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" 
                            value="{{ $audience->nombre }}" required>
                    </div>
                    <!-- Apellido Paterno -->
                    <div class="col-md-6">
                        <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
                        <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno"
                            value="{{ $audience->apellido_paterno }}">
                    </div>
                    <!-- Apellido Materno -->
                    <div class="col-md-6">
                        <label for="apellido_materno" class="form-label">Apellido Materno</label>
                        <input type="text" class="form-control" id="apellido_materno" name="apellido_materno"
                            value="{{ $audience->apellido_materno }}">
                    </div>
                    <!-- Teléfono -->
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono"
                            value="{{ $audience->telefono }}">
                    </div>
                    <!-- Lugar/Dependencia -->
                    <div class="col-md-12">
                        <label for="dependency_id" class="form-label">Dependencia</label>
                        <select class="form-select select2" id="dependency_id" name="dependency_id">
                            <option value="">Seleccione una dependencia</option>
                            @foreach($dependencies as $dependency)
                                <option value="{{ $dependency->id }}" {{ $audience->dependency_id == $dependency->id ? 'selected' : '' }}>
                                    {{ $dependency->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Asunto -->
                    <div class="col-md-12">
                        <label for="asunto" class="form-label">Asunto</label>
                        <input type="text" class="form-control" id="asunto" name="asunto" 
                            value="{{ $audience->asunto }}" required>
                    </div>
                    <!-- Email -->
                    <div class="col-md-6">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" 
                            value="{{ $audience->email }}">
                    </div>
                    <!-- Fecha -->
                    <div class="col-md-6">
                        <label for="fecha_llegada" class="form-label">Fecha de Llegada</label>
                        <input type="date" class="form-control" id="fecha_llegada" name="fecha_llegada" 
                            value="{{ $audience->fecha_llegada ? $audience->fecha_llegada->format('Y-m-d') : '' }}" required>
                    </div>
                    <!-- Hora -->
                    <div class="col-md-6">
                        <label for="hora_llegada" class="form-label">Hora de Llegada</label>
                        <input type="time" class="form-control" id="hora_llegada" name="hora_llegada"
                            value="{{ $audience->hora_llegada }}" required>
                    </div>
                    <!-- Tipo de Contacto -->
                    <div class="col-md-6">
                        <label for="contact_type_id" class="form-label">Tipo de Contacto</label>
                        <select class="form-select select2" id="contact_type_id" name="contact_type_id" required>
                            <option value="">Seleccione un tipo</option>
                            @foreach($contactTypes as $type)
                                <option value="{{ $type->id }}" {{ $audience->contact_type_id == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Cargo -->
                    <div class="col-md-6">
                        <label for="cargo" class="form-label">Cargo</label>
                        <input type="text" class="form-control" id="cargo" name="cargo" 
                            value="{{ $audience->cargo }}">
                    </div>
                    <!-- Observacion -->
                    <div class="col-md-12">
                        <label for="observacion" class="form-label">Observación</label>
                        <textarea class="form-control" id="observacion" name="observacion" rows="3">{{ $audience->observacion }}</textarea>
                    </div>
                    <!-- Estado -->
                    <div class="col-md-6">
                        <label for="audience_status_id" class="form-label">Estado de la Audiencia</label>
                        <select class="form-select select2" id="audience_status_id" name="audience_status_id" required>
                            <option value="">Seleccione un estado</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" {{ $audience->audience_status_id == $status->id ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <hr>
                    <!-- Acompañantes -->
                    <div class="col-md-12">
                        <label class="form-label"><strong>Acompañantes</strong></label>
                        <button id="add-companion" type="button" class="btn btn-sm btn-success mb-3">Agregar Acompañante</button>
                        <div id="companions-container">
                            @foreach ($audience->companions as $companion)
                                <div class="row g-3 companion-row mb-2">
                                    <div class="col-md-3">
                                        <input type="text" name="companions[{{ $companion->id }}][nombre]" class="form-control" value="{{ $companion->nombre }}" required>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="companions[{{ $companion->id }}][telefono]" class="form-control" value="{{ $companion->telefono }}">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="email" name="companions[{{ $companion->id }}][email]" class="form-control" value="{{ $companion->email }}">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="companions[{{ $companion->id }}][cargo]" class="form-control" value="{{ $companion->cargo }}">
                                    </div>
                                    <div class="col-md-1 d-flex align-items-center">
                                        <button type="button" class="btn btn-sm btn-danger remove-companion">Eliminar</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="mt-4 d-flex justify-content-center">
                    <!-- Botón Actualizar -->
                    <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                    <!-- Botón Regresar -->
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="{{ route('audiences.index') }}" class="btn btn-secondary btn-sm">Regresar</a>
                </div>
            </form>
        </div>
    </div>
</div>
<br><br><br>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        // Inicializar Select2
        $('.select2').select2({
            placeholder: "Seleccione",
            allowClear: true, // Permite limpiar la selección
            width: '100%' // Ajusta el ancho del select
        });
    });

    // Acompañante
    let companionIndex = {{ $audience->companions->count() }};

$('#add-companion').on('click', function () {
    const container = $('#companions-container');
    const newRow = `
        <div class="row g-3 companion-row mb-2">
            <div class="col-md-3">
                <input type="text" name="companions[new_${companionIndex}][nombre]" class="form-control" placeholder="Nombre">
            </div>
            <div class="col-md-2">
                <input type="text" name="companions[new_${companionIndex}][telefono]" class="form-control" placeholder="Teléfono">
            </div>
            <div class="col-md-3">
                <input type="email" name="companions[new_${companionIndex}][email]" class="form-control" placeholder="Correo Electrónico">
            </div>
            <div class="col-md-3">
                <input type="text" name="companions[new_${companionIndex}][cargo]" class="form-control" placeholder="Cargo">
            </div>
            <div class="col-md-1 d-flex align-items-center">
                <button type="button" class="btn btn-sm btn-danger remove-companion">Eliminar</button>
            </div>
        </div>
    `;
    container.append(newRow);
    companionIndex++;
});

$(document).on('click', '.remove-companion', function () {
    $(this).closest('.companion-row').remove();
});
</script>
@endpush
