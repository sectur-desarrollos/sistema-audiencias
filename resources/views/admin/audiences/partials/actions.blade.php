<div class="d-flex justify-content-center">
    <button type="button" class="btn btn-success btn-sm btn-action" data-action="pdf" data-id="{{ $row->id }}">
        <i class="bi bi-file-earmark-pdf-fill" title="Generar PDF"></i>
    </button>
    <button type="button" class="btn btn-info btn-sm btn-action" data-action="show" data-id="{{ $row->id }}">
        <i class="bi bi-eye-fill" title="Mostrar"></i>
    </button>
    <a href="{{ route('audiences.edit', $row) }}" class="btn btn-warning btn-sm">
        <i class="bi bi-pencil-fill" title="Editar"></i>
    </a>
    <button class="btn btn-danger btn-sm btn-action" data-action="delete" data-id="{{ $row->id }}">
        <i class="bi bi-trash-fill" title="Eliminar"></i>
    </button>
</div>
