@extends('admin.audiences.pdf.pdf-template')

@section('pdf_name', 'Audiencia PDF')

@section('contenido')
{{-- <h4 style="text-align: center; font-size: 10px;">Detalle de Audiencia</h4> --}}
    <!-- Información general -->
    <table class="companions-table" style="width: 100%;">
        <tr>
            <td style="width: 50%;">
                <strong>Nombre:</strong> {{ $audience->nombre }} {{ $audience->apellido_paterno }} {{ $audience->apellido_materno }}<br>
                <strong>Cargo:</strong> {{ $audience->cargo ? $audience->cargo  : 'N/A' }}<br>
                <strong>Email:</strong> {{ $audience->email ? $audience->email : 'N/A' }}<br>
                <strong>Teléfono:</strong> {{ $audience->telefono ? $audience->telefono : 'N/A' }}<br>
                <strong>Lugar/Dependencia:</strong> {{ $audience->dependency->name ? $audience->dependency->name : 'N/A' }}<br>
                <strong>Como se comunicó:</strong> {{ $audience->contactType->name ? $audience->contactType->name : 'N/A' }}
            </td>
            <td style="width: 50%; vertical-align: top;">
                <strong>Asunto:</strong><br>
                <span>{{ $audience->asunto }}</span><br><br>
                <strong>Observaciones:</strong><br>
                <span>{{ $audience->observacion ? $audience->observacion : 'N/A' }}</span>
            </td>
        </tr>
    </table>
</div>
<br>
<br>
<br>

<!-- Acompañantes -->
@if ($audience->companions->isNotEmpty())
<div class="content" style="margin-top: 20px;">
    <h4 style="text-align: center; font-size: 10px;">Acompañantes</h4>
    <table class="companions-table" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="text-align: left; padding: 5px;">Nombre</th>
                <th style="text-align: left; padding: 5px;">Cargo</th>
                <th style="text-align: left; padding: 5px;">Teléfono</th>
                <th style="text-align: left; padding: 5px;">Correo Electrónico</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($audience->companions as $companion)
            <tr>
                <td style="padding: 5px;">{{ $companion->nombre }}</td>
                <td style="padding: 5px;">{{ $companion->cargo }}</td>
                <td style="padding: 5px;">{{ $companion->telefono }}</td>
                <td style="padding: 5px;">{{ $companion->email }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@endsection