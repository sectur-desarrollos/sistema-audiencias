@extends('admin.layout.general')

@section('nombre_seccion', 'Audiencias')

@section('contenido')
    <a href="{{ route('audiences.create') }}" class="btn btn-primary mb-3">Nueva Audiencia</a>
    
    <div class="table-responsive">
            {{-- <table id="audiences-table" class="table table-bordered" > --}}
        <table id="audiences-table" class="table table-bordered display nowrap" style="width:100%">

            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Asunto</th>
                    <th>Estado</th>
                    <th>Fecha/Hora</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>

<!-- Modal para seleccionar tipo de PDF -->
<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="pdfModalLabel">Generar PDF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body text-center">
                <p>Seleccione el tipo de PDF que desea generar:</p>
                <button id="btn-pdf-full" class="btn btn-success btn-sm" target="_blank">Audiencia Completa</button>
                <button id="btn-pdf-companies" class="btn btn-info btn-sm" target="_blank">Audiencia con Acompañantes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para mostrar detalles de la audiencia -->
<div class="modal fade" id="showAudienceModal" tabindex="-1" aria-labelledby="showAudienceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="showAudienceModalLabel">Detalles de la Audiencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <!-- Campos dinámicos para detalles -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Folio</strong></label>
                        <div class="form-control" id="audience-folio"></div>
                    </div>
                    <!-- Nombre -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Nombre</strong></label>
                        <div class="form-control" id="audience-nombre"></div>
                    </div>
                    <!-- Apellido Paterno -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Apellido Paterno</strong></label>
                        <div class="form-control" id="audience-apellido-paterno"></div>
                    </div>
                    <!-- Apellido Materno -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Apellido Materno</strong></label>
                        <div class="form-control" id="audience-apellido-materno"></div>
                    </div>
                    <!-- Teléfono -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Teléfono</strong></label>
                        <div class="form-control" id="audience-telefono"></div>
                    </div>
                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Correo Electrónico</strong></label>
                        <div class="form-control" id="audience-email"></div>
                    </div>
                    <!-- Lugar/Dependencia -->
                    <div class="col-md-12">
                        <label class="form-label"><strong>Lugar/Dependencia</strong></label>
                        <div class="form-control" id="audience-lugar-dependencia"></div>
                    </div>
                    <!-- Asunto -->
                    <div class="col-md-12">
                        <label class="form-label"><strong>Asunto</strong></label>
                        <div class="form-control" id="audience-asunto"></div>
                    </div>
                    <!-- Fecha -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Fecha de Llegada</strong></label>
                        <div class="form-control" id="audience-fecha-llegada"></div>
                    </div>
                    <!-- Hora -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Hora de Llegada</strong></label>
                        <div class="form-control" id="audience-hora-llegada"></div>
                    </div>
                    <!-- Tipo de Contacto -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Tipo de Contacto</strong></label>
                        <div class="form-control" id="audience-tipo-contacto"></div>
                    </div>
                    <!-- Cargo -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Cargo</strong></label>
                        <div class="form-control" id="audience-cargo"></div>
                    </div>
                    <!-- Observación -->
                    <div class="col-md-12">
                        <label class="form-label"><strong>Observación</strong></label>
                        <div class="form-control" id="audience-observacion"></div>
                    </div>
                    <!-- Observación -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Estado de la audiencia</strong></label>
                        <div class="form-control" id="audience-status"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        let selectedAudienceId = null;

        // Inicializar DataTable
        const table = $('#audiences-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true, // Habilitar modo responsive
        ajax: "{{ route('audiences.data') }}",
        columns: [
            { data: 'nombre', name: 'nombre', orderable: false, searchable: true },
            { data: 'asunto', name: 'asunto', orderable: false },
            { data: 'status_badge', name: 'status_badge', orderable: false, searchable: false },
            { data: 'fecha_llegada', name: 'fecha_llegada', orderable: false },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        language: {
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "No se encontraron registros",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "No hay registros disponibles",
            infoFiltered: "(filtrado de _MAX_ registros totales)",
            search: "Buscar:",
            paginate: {
                next: "Siguiente",
                previous: "Anterior"
            }
        },
        // Estas lineas de abajo son para mantener el estado de la paginación de DataTables
        stateSave: true,
        stateSaveCallback: function(settings,data) {
            localStorage.setItem( 'DataTables_' + settings.sInstance, JSON.stringify(data) )
        },
        stateLoadCallback: function(settings) {
            return JSON.parse( localStorage.getItem( 'DataTables_' + settings.sInstance ) )
        }
    });


        // Manejar eventos en botones de acciones
        $('#audiences-table').on('click', '.btn-action', function () {
            const action = $(this).data('action');
            const id = $(this).data('id');
            if (action === 'pdf') {
                selectedAudienceId = id;
                $('#pdfModal').modal('show');
            } else if (action === 'show') {
                const audience = table.row($(this).parents('tr')).data();
                $("#audience-folio").text(audience.folio || "N/A");
                $("#audience-nombre").text(audience.nombre || "N/A");
                $("#audience-apellido-paterno").text(audience.apellido_paterno || "N/A");
                $("#audience-apellido-materno").text(audience.apellido_materno || "N/A");
                $("#audience-asunto").text(audience.asunto || "N/A");
                $("#audience-fecha-llegada").text(audience.fecha_llegada || "N/A");
                $("#audience-hora-llegada").text(audience.hora_llegada || "N/A");
                $("#audience-telefono").text(audience.telefono || "N/A");
                $("#audience-lugar-dependencia").text(audience.dependency.name || "N/A");
                $("#audience-tipo-contacto").text(audience.contact_type.name || "N/A");
                $("#audience-cargo").text(audience.cargo || "N/A");
                $("#audience-email").text(audience.email || "N/A");
                $("#audience-observacion").text(audience.observacion || "N/A");
                $("#audience-status").text(audience.status.name || "N/A");
                // Rellenar otros campos dinámicamente...
                $('#showAudienceModal').modal('show');
            } else if (action === 'delete') {
                if (confirm('¿Eliminar esta audiencia?')) {
                    $.ajax({
                        url: `/audiences/${id}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function () {
                            table.ajax.reload();
                            alert('Audiencia eliminada correctamente');
                        },
                        error: function () {
                            alert('Hubo un error al eliminar la audiencia');
                        }
                    });
                }
            }
        });

        // Generar PDFs desde el modal
        $('#btn-pdf-full').on('click', function () {
            window.open(`/audiences/${selectedAudienceId}/pdf`, '_blank');
        });
        $('#btn-pdf-companies').on('click', function () {
            window.open(`/audiences/${selectedAudienceId}/pdf-companies`, '_blank');
        });
    });
</script>
@endpush
