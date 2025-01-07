<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('pdf_name')</title>
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
            left: 360px;
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
    <!-- Header -->
    <div class="header">
        <img src="{{ public_path('assets/audiencia/pdf/logo_pdf_audiencia.png') }}" alt="Logo Sectur">
        {{-- <img src="{{ public_path('assets/audiencia/pdf/secturchiapas_sin_fondo.png') }}" alt="Logo Sectur"> --}}
            <br>
            <div class="date-time">
                <label>{{ \Carbon\Carbon::parse($audience->fecha_llegada)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}
                </label><br>
                <label>Hora: {{ \Carbon\Carbon::parse($audience->hora_llegada)->format('H:i:s') }} hrs</label>
            </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <img src="{{ public_path('assets/audiencia/pdf/greca_v3.png') }}" alt="Greca Footer">
    </div>

    <!-- Contenido -->
    <div class="content">
        @yield('contenido')
    </div>
</body>

</html>
