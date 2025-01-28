@extends('admin.layout.general')

@section('nombre_seccion', 'Catálogo de Estados de Audiencias')

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
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Nuevo Estado</button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Color</th>
                    <th>Activo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($statuses as $status)
                    <tr>
                        <td>{{ $status->name }}</td>
                        <td><span style="background-color: {{ $status->color }}; padding: 5px 10px; color: #fff;">{{ $status->color }}</span></td>
                        <td>{{ $status->activo ? 'Sí' : 'No' }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $status->id }}">Editar</button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $status->id }}">Eliminar</button>
                        </td>
                    </tr>

                    <!-- Modal para editar -->
                    <div class="modal fade" id="editModal{{ $status->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('audience-statuses.update', $status->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Estado</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nombre</label>
                                            <input type="text" class="form-control" name="name" value="{{ $status->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Descripción</label>
                                            <textarea class="form-control" name="description" rows="3">{{ $status->description }}</textarea>
                                        </div>                                        
                                        <div class="mb-3">
                                            <label for="color" class="form-label">Color</label>
                                            <input type="color" class="form-control form-control-color" name="color" value="{{ $status->color }}">
                                        </div>
                                        <div class="form-check">
                                            <input type="hidden" name="activo" value="0">
                                            <input type="checkbox" class="form-check-input" name="activo" value="1" {{ $status->activo ? 'checked' : '' }}>
                                            <label class="form-check-label">Activo</label>
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
                    <div class="modal fade" id="deleteModal{{ $status->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('audience-statuses.destroy', $status->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Eliminar Estado</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Estás seguro de que deseas eliminar el estado <strong>{{ $status->name }}</strong>?</p>
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
                        <td colspan="4" class="text-center">No hay estados registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $statuses->links() }}
    </div>
</div>

<!-- Modal para crear -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('audience-statuses.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Estado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">Color</label>
                        <input type="color" class="form-control form-control-color" name="color">
                    </div>
                    <div class="form-check">
                        <input type="hidden" name="activo" value="0">
                        <input type="checkbox" class="form-check-input" name="activo" value="1" checked>
                        <label class="form-check-label">Activo</label>
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
