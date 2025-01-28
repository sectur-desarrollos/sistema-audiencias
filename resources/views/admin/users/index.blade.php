@extends('admin.layout.general')

@section('nombre_seccion', 'Gestión de Usuarios')

@section('contenido')
<div class="container">
    <div id="alert-placeholder">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Nuevo Usuario</button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle" id="usersTable">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Nickname</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modales -->

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar este usuario?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger btn-confirm-delete">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<!-- Show Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Detalles del Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nombre:</strong> <span id="view-name"></span></p>
                <p><strong>Nickname:</strong> <span id="view-nickname"></span></p>
                <p><strong>Email:</strong> <span id="view-email"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="edit-form" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-name" class="form-label">Nombre</label>
                        <input type="text" name="name" id="edit-name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-nickname" class="form-label">Nickname</label>
                        <input type="text" name="nickname" id="edit-nickname" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-email" class="form-label">Email</label>
                        <input type="email" name="email" id="edit-email" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="edit-password" class="form-label">Nueva Contraseña</label>
                        <div class="input-group">
                            <input type="password" name="password" id="edit-password" class="form-control">
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#edit-password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <small class="text-muted">Deja este campo vacío si no deseas cambiar la contraseña.</small>
                    </div>
                    <div class="mb-3">
                        <label for="edit-password-confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="edit-password-confirmation" class="form-control">
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#edit-password-confirmation">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Nuevo Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="nickname" class="form-label">Nickname</label>
                        <input type="text" name="nickname" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control" required>
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
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
    $(document).ready(function () {
        const usersTable = $('#usersTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('users.data') }}',
            columns: [
                { data: 'name', name: 'name' },
                { data: 'nickname', name: 'nickname' },
                { data: 'email', name: 'email' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });

        // Mostrar mensaje de alerta
        function showMessage(type, message) {
            const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`;
            $('#alert-placeholder').html(alertHtml);
        }

        // Ver usuario
        $(document).on('click', '.btn-view', function () {
            const userId = $(this).data('id');
            $.get(`/users/${userId}`, function (data) {
                $('#view-name').text(data.name);
                $('#view-nickname').text(data.nickname);
                $('#view-email').text(data.email);
                $('#viewModal').modal('show');
            }).fail(function () {
                showMessage('danger', 'Error al cargar los detalles del usuario.');
            });
        });

        // Editar usuario
        $(document).on('click', '.btn-edit', function () {
            const userId = $(this).data('id');
            $.get(`/users/${userId}`, function (data) {
                $('#edit-name').val(data.name);
                $('#edit-nickname').val(data.nickname);
                $('#edit-email').val(data.email);
                $('#edit-form').attr('action', `/users/${userId}`);
                $('#editModal').modal('show');
            }).fail(function () {
                showMessage('danger', 'Error al cargar los detalles del usuario.');
            });
        });

        // Actualizar usuario
        $('#edit-form').on('submit', function (e) {
            e.preventDefault();
            const formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                method: 'PUT',
                data: formData,
                success: function (response) {
                    $('#editModal').modal('hide');
                    usersTable.ajax.reload();
                    showMessage('success', response.success);
                },
                error: function (xhr) {
                    console.log(xhr.responseText); // Para depurar el error
                    showMessage('danger', 'Error al actualizar el usuario.');
                }
            });
        });


        // Eliminar usuario
        let userIdToDelete;
        $(document).on('click', '.btn-delete', function () {
            userIdToDelete = $(this).data('id');
        });

        $(document).on('click', '.btn-confirm-delete', function () {
            if (userIdToDelete) {
                $.ajax({
                    url: `/users/${userIdToDelete}`,
                    method: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function () {
                        $('#deleteModal').modal('hide');
                        usersTable.ajax.reload();
                        showMessage('success', 'Usuario eliminado exitosamente.');
                    },
                    error: function () {
                        showMessage('danger', 'Error al eliminar el usuario.');
                    }
                });
            }
        });
    });
</script>
@endpush
