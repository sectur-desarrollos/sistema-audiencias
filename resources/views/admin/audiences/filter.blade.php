@extends('admin.layout.general')

@section('nombre_seccion', 'Audiencias - Filtro')

@section('contenido')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Filtro de Audiencias</h2>
        <button id="btn-export-pdf" class="btn btn-danger">Exportar a PDF</button>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <label for="start_date">Fecha de inicio:</label>
            <input type="date" id="start_date" class="form-control">
        </div>
        <div class="col-md-4">
            <label for="end_date">Fecha de fin:</label>
            <input type="date" id="end_date" class="form-control">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button id="btn-filter" class="btn btn-primary w-100">Filtrar</button>
        </div>
    </div>

    <div class="table-responsive">
        <table id="audiences-table" class="table table-bordered display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>Nombre</th>
                    <th>Asunto</th>
                    <th>Estado</th>
                    <th>Fecha/Hora</th>
                    {{-- <th>Acciones</th> --}}
                </tr>
            </thead>
        </table>
    </div>
@endsection

@push('js')
<script>
    localStorage.clear();
    $(document).ready(function () {
        const table = $('#audiences-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('audiences.filter') }}",
                data: function (d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                }
            },
            columns: [
                { data: 'id', render: function(data) {
                    return `<input type="checkbox" class="select-row" value="${data}">`;
                }, orderable: false, searchable: false },
                { data: 'nombre', name: 'nombre' },
                { data: 'asunto', name: 'asunto' },
                { data: 'status_badge', name: 'status_badge', orderable: false, searchable: false },
                { data: 'fecha_llegada', name: 'fecha_llegada' },
                // { data: 'actions', name: 'actions', orderable: false, searchable: false }
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
            // localStorage.clear();
            // Estas lineas de abajo son para mantener el estado de la paginación de DataTables
            stateSave: true,
            stateSaveCallback: function(settings,data) {
                localStorage.setItem( 'DataTables_' + settings.sInstance, JSON.stringify(data) )
            },
            stateLoadCallback: function(settings) {
                return JSON.parse( localStorage.getItem( 'DataTables_' + settings.sInstance ) )
            }
        });

        $('#btn-filter').click(function () {
            table.ajax.reload();
        });

        $('#select-all').change(function () {
            $('.select-row').prop('checked', $(this).prop('checked'));
        });

        $('#btn-export-pdf').click(function () {
            const selectedIds = $('.select-row:checked').map(function () {
                return $(this).val();
            }).get();

            $.ajax({
                url: "{{ route('audiences.export.pdf') }}",
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: { ids: selectedIds },
                xhrFields: { responseType: 'blob' },
                success: function (data) {
                    const url = window.URL.createObjectURL(data);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'audiencias.pdf';
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                },
                error: function () {
                    alert('Error al exportar a PDF.');
                }
            });
        });
    });
</script>
@endpush