<div class="d-flex gap-2">
    <button class="btn btn-info btn-sm btn-view" data-id="{{ $user->id }}" data-bs-toggle="modal" data-bs-target="#viewModal">
        <i class="bi bi-eye-fill" title="Mostrar"></i>
    </button>
    <button class="btn btn-warning btn-sm btn-edit" data-id="{{ $user->id }}" data-bs-toggle="modal" data-bs-target="#editModal">
        <i class="bi bi-pencil-fill" title="Editar"></i>
    </button>
    <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $user->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal">
        <i class="bi bi-trash-fill" title="Eliminar"></i>
    </button>
</div>