@extends('admin.layout.general')

@section('nombre_seccion', 'Audiencias')

@section('contenido')
@if ($errors->any())
<div class="alert alert-danger">{{ $errors->first() }}</div>
@endif
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="container mt-4">
    <a href="{{ route('audiences.create') }}" class="btn btn-primary mb-3">Nueva Audiencia</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Asunto</th>
                <th>Estado</th>
                <th>Fecha/Hora</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($audiences as $audience)
            <tr>
                <!-- Nombre -->
                <td>{{ $audience->nombre }} {{ $audience->apellido_paterno }} {{ $audience->apellido_materno }}</td>

                <!-- Asunto -->
                <td>{{ $audience->asunto }}</td>

                <!-- Estado con badge -->
                <td>
                    @if($audience->status)
                    <span title="{{ $audience->status->description }}" class="badge"
                        style="background-color: {{ $audience->status->color }}; color: #fff;">
                        {{ $audience->status->name }}
                    </span>
                    @else
                    <span class="badge bg-secondary">Sin Estado</span>
                    @endif
                </td>

                <!-- Fecha/Hora -->
                <td>
                    {{ \Carbon\Carbon::parse($audience->fecha_llegada)->format('Y-m-d') }}
                    {{ \Carbon\Carbon::parse($audience->hora_llegada)->format('H:i:s') }}
                </td>

                <!-- Acciones -->
                <td class="text-center">
                    <!-- Botón para PDF -->
                    <button type="button" class="btn btn-success btn-sm btn-pdf" title="Generar PDF"
                        data-bs-toggle="modal" data-bs-target="#pdfModal" data-id="{{ $audience->id }}">
                        <i class="bi bi-file-earmark-pdf-fill"></i>
                    </button>
                    <!-- Botón para mostrar -->
                    <button type="button" class="btn btn-info btn-sm btn-show" data-bs-toggle="modal"
                        data-bs-target="#showAudienceModal" data-audience="{{ $audience->toJson() }}">
                        <i class="bi bi-eye-fill" title="Mostrar"></i>
                    </button>
                    <!-- Botón para editar -->
                    <a href="{{ route('audiences.edit', $audience) }}" class="btn btn-warning btn-sm" title="Editar">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                    <!-- Botón para eliminar -->
                    <form action="{{ route('audiences.destroy', $audience) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" title="Eliminar"
                            onclick="return confirm('¿Eliminar esta audiencia?')">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
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
                <button id="btn-pdf-companies" class="btn btn-info btn-sm" target="_blank">Audiencia con
                    Acompañantes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para mostrar detalles de la audiencia -->
<div class="modal fade" id="showAudienceModal" tabindex="-1" aria-labelledby="showAudienceModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="showAudienceModalLabel">Detalles de la Audiencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <!-- Folio -->
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
            <div class="modal-footer d-flex justify-content-between">
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

        // Manejar el evento click en el botón PDF
        $(".btn-pdf").on("click", function () {
            selectedAudienceId = $(this).data("id");
        });

        // Redirigir al PDF completo
        $("#btn-pdf-full").on("click", function () {
            window.open(`/audiences/${selectedAudienceId}/pdf`, '_blank');
        });

        // Redirigir al PDF completo
        $("#btn-pdf-companies").on("click", function () {
            window.open(`/audiences/${selectedAudienceId}/pdf-companies`, '_blank');
        });

        // Manejar el evento click en los botones de mostrar
        $(".btn-show").on("click", function () {
            console.log('hola')
            let audience = $(this).data("audience");
            console.log(audience)

            // Llenar los datos en el modal
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
        });
    });

</script>
@endpush
