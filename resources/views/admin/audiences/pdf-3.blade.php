<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Audiencia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px; /* Tamaño general */
            margin: 0;
            padding: 0;
        }
        .recibo {
            border: 1px solid black;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .header {
            /* border: 1px solid black;
            border-radius: 10px; */
            padding: 8px;
            margin-bottom: 30px;
            height: 70px; /* Ajustado para el tamaño más pequeño */
            position: relative;
            text-align: center;
        }
        .header img {
            height: 150px; /* Tamaño de las imágenes */

        }
        /* .header .logo-left {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
        } */
        .header .title {
            text-align: center;
            font-size: 9px; /* Reducido solo el tamaño de la fuente del título */
            font-weight: bold;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            line-height: 1.2; /* Ajusta el interlineado */
        }
        .header .logo-right {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
        }
        .info {
            display: table;
            width: 100%;
            margin: 10px 0;
        }
        .info .info-box {
            display: table-cell;
            /* border: 1px solid black;
            border-radius: 5px; */
            padding: 5px;
            text-align: center;
            vertical-align: middle;
        }
        .info .info-box:first-child {
            margin-right: 5px;
        }
        .content {
            margin: 8px 0;
        }
        .content p {
            margin: 3px 0;
        }
        .content .line {
            border-bottom: 1px solid black;
            margin-top: 3px;
        }
        .footer {
            text-align: center;
            margin-top: 15px;
        }
        .greca-footer{
            width: 90%
        }
        .footer hr {
            width: 50%;
            margin: 8px auto;
        }
    </style>
</head>
<body>
    <div class="recibo">
        <!-- Encabezado -->
        <div class="header">
            <img src="{{ public_path('assets/audiencia/pdf/secturchiapas_sin_fondo.png') }}" alt="Logo sectur nueva era" class="logo-sectur-nueva-era">
        </div>

        <!-- Información de Fecha y Folio -->
        <div class="info">
            <div class="info-box">
                <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($audience->fecha_llegada)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</p>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            <div class="info-box">
                <p><strong>Folio:</strong> {{ $audience->folio }}</p>
            </div>
        </div>

        <!-- Contenido del Recibo -->
        <div class="content">
            <p><strong>Nombre:</strong> {{ $audience->nombre }} {{ $audience->apellido_paterno }} {{ $audience->apellido_materno }}</p>
            <div class="line"></div>
            <p><strong>Teléfono:</strong> {{ $audience->telefono }}</p>
            <div class="line"></div>
            <p><strong>Asunto:</strong> {{ $audience->asunto }}</p>
            <div class="line"></div>
        </div>

        <!-- Pie del Recibo -->
        <div class="footer">
            {{-- <hr> --}}
            {{-- <p>{{ $tesoreroNombre }}</p>
            <p>V.·. H.·. Tesorero</p> --}}
            {{-- <hr> --}}
            <img src="{{ public_path('assets/audiencia/pdf/greca.png') }}" alt="Greca footer" class="greca-footer">
        </div>
    </div>
</body>
</html>
