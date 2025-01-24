@extends('admin.layout.general')

@section('nombre_seccion', 'Catálogo de Municipios')

@section('contenido')
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Nuevo Municipio</button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Activo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($municipalities as $municipality)
                    <tr>
                        <td>{{ $municipality->name }}</td>
                        <td>{{ $municipality->state->name }}</td>
                        <td>{{ $municipality->activo ? 'Sí' : 'No' }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $municipality->id }}">Editar</button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $municipality->id }}">Eliminar</button>
                        </td>
                    </tr>

                    <!-- Modal para editar -->
                    <div class="modal fade editModal" id="editModal{{ $municipality->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $municipality->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('municipalities.update', $municipality) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel{{ $municipality->id }}">Editar Municipio</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="state_id" class="form-label">Estado</label>
                                            <select name="state_id" class="form-control select2">
                                                @foreach ($states as $state)
                                                    <option value="{{ $state->id }}" {{ $municipality->state_id == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nombre</label>
                                            <input type="text" name="name" class="form-control" value="{{ $municipality->name }}" required>
                                        </div>
                                        <div class="form-check">
                                            <input type="hidden" name="activo" value="0">
                                            <input type="checkbox" name="activo" value="1" class="form-check-input" id="activo{{ $municipality->id }}" {{ $municipality->activo ? 'checked' : '' }}>
                                            <label for="activo{{ $municipality->id }}" class="form-check-label">Activo</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal para eliminar -->
                    <div class="modal fade" id="deleteModal{{ $municipality->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $municipality->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('municipalities.destroy', $municipality) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $municipality->id }}">Eliminar Municipio</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Estás seguro de que deseas eliminar el municipio <strong>{{ $municipality->name }}</strong>?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No hay municipios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $municipalities->links() }}
    </div>
</div>

<!-- Modal para crear -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('municipalities.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Nuevo Municipio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="state_id" class="form-label">Estado</label>
                        <select name="state_id" class="form-control select2" required>
                            <option value="">Selecciona un estado</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-check">
                        <input type="hidden" name="activo" value="0">
                        <input type="checkbox" name="activo" value="1" class="form-check-input" id="activo">
                        <label for="activo" class="form-check-label">Activo</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Inicializar Select2 en el modal de creación
        $('#createModal .select2').select2({
            width: '100%',
            dropdownParent: $('#createModal'), // Vincular al modal
            placeholder: "Selecciona un estado",
            allowClear: true
        });

        // Inicializar Select2 en cada modal de edición
        $('.editModal .select2').select2({
            width: '100%',
            dropdownParent: $('.editModal'), // Vincular al modal correspondiente
            placeholder: "Selecciona un estado",
            allowClear: true
        });

        // Solución para problemas de z-index
        $(document).on('select2:open', () => {
            document.querySelector('.select2-container').style.zIndex = 1056;
        });
    });
</script>

@endpush
