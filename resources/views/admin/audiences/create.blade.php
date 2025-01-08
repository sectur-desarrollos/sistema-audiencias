@extends('admin.layout.general')

@section('nombre_seccion', 'Crear audiencia')

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
            <form action="{{ route('audiences.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <!-- Nombre -->
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <!-- Apellido Paterno -->
                    <div class="col-md-6">
                        <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
                        <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno">
                    </div>
                    <!-- Apellido Materno -->
                    <div class="col-md-6">
                        <label for="apellido_materno" class="form-label">Apellido Materno</label>
                        <input type="text" class="form-control" id="apellido_materno" name="apellido_materno">
                    </div>
                    <!-- Teléfono -->
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" pattern="[0-9]+"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <small class="text-muted">Solo se permiten números.</small>
                    </div>
                    <!-- Lugar/Dependencia -->
                    <div class="col-md-12">
                        <label for="dependency_id" class="form-label">Dependencia</label>
                        <select class="form-select select2" id="dependency_id" name="dependency_id">
                            <option value="">Seleccione una dependencia</option>
                            @foreach($dependencies as $dependency)
                            <option value="{{ $dependency->id }}">{{ $dependency->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Asunto -->
                    <div class="col-md-12">
                        <label for="asunto" class="form-label">Asunto</label>
                        <input type="text" class="form-control" id="asunto" name="asunto" required>
                    </div>
                    <!-- Email -->
                    <div class="col-md-6">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email">
                        <small class="text-muted">Introduce un correo válido.</small>
                    </div>
                    <!-- Fecha -->
                    <div class="col-md-6">
                        <label for="fecha_llegada" class="form-label">Fecha de Llegada</label>
                        <input type="date" class="form-control" id="fecha_llegada" name="fecha_llegada" required>
                    </div>
                    <!-- Hora -->
                    <div class="col-md-6">
                        <label for="hora_llegada" class="form-label">Hora de Llegada</label>
                        <input type="time" class="form-control" id="hora_llegada" name="hora_llegada" required>
                    </div>
                    <!-- Tipo de Contacto -->
                    <div class="col-md-6">
                        <label for="contact_type_id" class="form-label">Tipo de Contacto</label>
                        <select class="form-select select2" id="contact_type_id" name="contact_type_id" required>
                            <option value="">Seleccione un tipo</option>
                            @foreach($contactTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Cargo -->
                    <div class="col-md-6">
                        <label for="cargo" class="form-label">Cargo</label>
                        <input type="text" class="form-control" id="cargo" name="cargo">
                    </div>
                    <!-- Observacion -->
                    <div class="col-md-12">
                        <label for="observacion" class="form-label">Observación</label>
                        <textarea class="form-control" id="observacion" name="observacion" rows="3"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="audience_status_id" class="form-label">Estado de la Audiencia</label>
                        <select class="form-select select2" id="audience_status_id" name="audience_status_id" required>
                            <option value="">Seleccione un estado</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <hr>
                    {{-- Acompañante --}}
                    <div class="mb-3">
                        <label class="form-label"><strong>Acompañantes</strong></label>
                        <button id="add-companion" type="button" class="btn btn-sm btn-success mb-3">Agregar Acompañante</button>
                        <div id="companions-container">
                            <!-- Aquí se agregarán las filas dinámicamente -->
                        </div>
                    </div>
                </div>
                <div class="mt-4 d-flex justify-content-center">
                    <!-- Botón Guardar -->
                    <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                    <!-- Botón Regresar -->
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="{{ route('audiences.index') }}" class="btn btn-secondary btn-sm">Regresar</a>
                </div>
            </form>
        </div>
    </div>
</div>
<br> <br> <br>
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


        let companionIndex = 1;
        const maxCompanions = 10; // Máximo de acompañantes permitidos

        $('#add-companion').on('click', function () {
            const container = $('#companions-container');

            // Verificar si ya se alcanzó el límite
            if ($('.companion-row').length >= maxCompanions) {
                alert('Solo puedes agregar un máximo de 10 acompañantes.');
                return;
            }

            const newRow = `
                <div class="row g-3 companion-row mb-2">
                    <div class="col-md-3">
                        <input type="text" name="companions[${companionIndex}][nombre]" class="form-control" placeholder="Nombre">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="companions[${companionIndex}][telefono]" class="form-control" placeholder="Teléfono" pattern="[0-9]+"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                    <div class="col-md-3">
                        <input type="email" name="companions[${companionIndex}][email]" class="form-control" placeholder="Correo Electrónico">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="companions[${companionIndex}][cargo]" class="form-control" placeholder="Cargo">
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

            // Rehabilitar el botón si el número de acompañantes vuelve a ser menor al máximo
            if ($('.companion-row').length < maxCompanions) {
                $('#add-companion').prop('disabled', false);
            }
        });

    });
</script>
@endpush