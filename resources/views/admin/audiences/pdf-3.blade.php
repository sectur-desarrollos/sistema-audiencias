<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Audiencias Multiples</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            /* margin: .2em;
            padding: .2em; */
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 100px 0 50px 0; /* Márgenes solo superior e inferior */
        }
    
        /* Encabezado */
        .header {
            position: fixed;
            top: 0px;
            left: 0px;
            right: 285px;
            text-align: center;
            display: flex;
            justify-content: space-between; 
            /* border: 2px solid red; */
        }
    
        .header img {
            height: 50px;
        }

        .date-time {
            /* text-align: right; */
            /* border: 2px solid red; */
            position: relative;
            left: 450px;
            top:-50px;
            font-size: 8px;
        }
    
        /* Titulo */
        .title {    
        /* border: 2px solid red; */
            text-align: center;
            font-weight: bold;
            font-size: 8px;
        }

        /* Contenido */
        .companions-table {
            width: 100%;
            border-spacing: 0 5px; /* Espaciado entre filas */
        }
    
        .companions-table tr td {
            padding: 5px;
        }
    
        .companions-table .info-left {
            width: 60%;
        }
    
        .companions-table .info-right {
            width: 40%;
            text-align: right;
        }



        /* Footer */
        .footer {
            position: fixed;
            bottom: -20px;
            /* bottom: -35px; */
            left: 0px;
            right: 0px;
            height: 50px;
            text-align: center;
        }
    
        .footer img {
            width: 100%; /* La imagen ahora abarca el 100% del ancho de la página */
            height: auto; /* Mantiene la proporción original */
            margin: 0; /* Elimina cualquier margen */
        }
    
        .content {
            margin-top: -10px;
        }
    </style>
    
</head>

<body>
    @foreach ($audience as $a)
    <!-- Header -->
    <div class="header">
        <img src="{{ public_path('assets/audiencia/pdf/logo_pdf_audiencia.png') }}" alt="Logo Sectur">
        {{-- <img src="{{ public_path('assets/audiencia/pdf/secturchiapas_sin_fondo.png') }}" alt="Logo Sectur"> --}}
     </div>
    <div class="date-time">
        <label>{{ \Carbon\Carbon::parse($a->fecha_llegada)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}
        </label><br>
        <label>Hora: {{ \Carbon\Carbon::parse($a->hora_llegada)->format('H:i:s') }} hrs</label>
    </div>

    <!-- Footer -->
    <div class="footer">
        <img src="{{ public_path('assets/audiencia/pdf/greca_v3.png') }}" alt="Greca Footer">
    </div>

    {{-- Content --}}
    <div class="content" @if (!$loop->last) style="page-break-after: always;" @endif>
        <!-- Información general -->
        {{-- <h4 style="text-align: center; font-size: 10px;">Detalle de Audiencia</h4> --}}
        <table class="companions-table" style="width: 100%;">
            <tr>
                <td style="width: 50%;">
                    <strong>Nombre:</strong> {{ $a->nombre }} {{ $a->apellido_paterno }} {{ $a->apellido_materno }}<br>
                    <strong>Cargo:</strong> {{ $a->cargo ? $a->cargo : 'N/A' }}<br>
                    <strong>Email:</strong> {{ $a->email ? $a->email : 'N/A' }}<br>
                    <strong>Teléfono:</strong> {{ $a->telefono ? $a->telefono : 'N/A' }}<br>
                    <strong>Lugar/Dependencia:</strong> {{ $a->dependency->name ?? 'N/A' }}<br>
                    <strong>Estado/Municipio:</strong> {{ $a->state->name ? $a->state->name : 'N/A' }}, {{ $a->municipality->name ? $a->municipality->name : 'N/A' }} <br>
                    <strong>Cómo se comunicó:</strong> {{ $a->contactType->name ?? 'N/A' }}
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <strong>Asunto:</strong><br>
                    <span>{{ $a->asunto }}</span><br><br>
                    <strong>Observaciones:</strong><br>
                    <span>{{ $a->observacion ? $a->observacion : 'N/A' }}</span>
                </td>
            </tr>
        </table>
        <!-- Acompañantes -->
        @if ($a->companions->isNotEmpty())
        <br>
        <br>
        <br>
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
                    @foreach ($a->companions as $companion)
                        <tr>
                            <td style="padding: 5px;">{{ $companion->nombre }}</td>
                            <td style="padding: 5px;">{{ $companion->cargo }}</td>
                            <td style="padding: 5px;">{{ $companion->telefono }}</td>
                            <td style="padding: 5px;">{{ $companion->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    
    @endforeach
</body>

</html>
