<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audiencia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .container {
            width: 100%;
            margin: auto;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .field {
            margin-bottom: 10px;
        }
        .field strong {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; background: url('{{ public_path('assets/audiencia/pdf/secturchiapas_blanco.png') }}') no-repeat center center; background-size: contain; opacity: 0.5;">
        {{-- <img src="{{ public_path('assets/audiencia/pdf/secturchiapas_blanco.png') }}" style="width: auto; height: 100%; max-width: 100%; max-height: 100%; margin: auto; display: block; opacity: 0.5;"> --}}
    </div>
    <div class="container">
        <div class="title">Solicitud de Audiencia</div>
        <div class="field"><strong>Folio:</strong> {{ $audience->folio }}</div>
        <div class="field"><strong>Fecha/Hora:</strong>  
            {{ \Carbon\Carbon::parse($audience->fecha_llegada)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }} a las {{ \Carbon\Carbon::parse($audience->hora_llegada)->format('H:i:s') }} hrs
        </div>
        <div class="field"><strong>Nombre:</strong> {{ $audience->nombre }} {{ $audience->apellido_paterno }} {{ $audience->apellido_materno }}</div>
        <div class="field"><strong>Email:</strong> {{ $audience->email ? $audience->email : 'N/A' }}</div>
        <div class="field"><strong>Teléfono:</strong> {{ $audience->telefono ? $audience->telefono : 'N/A' }}</div>
        <div class="field"><strong>Lugar/Dependencia:</strong> {{ $audience->dependency->name ? $audience->dependency->name : 'N/A' }}</div>
        <div class="field"><strong>Cargo:</strong> {{ $audience->cargo ? $audience->cargo  : 'N/A'}}</div>
        <div class="field"><strong>Asunto:</strong> {{ $audience->asunto }}</div>
        <div class="field"><strong>Tipo de Contacto:</strong> {{ $audience->contactType->name }}</div>
        <div class="field"><strong>Observaciones:</strong> {{ $audience->observacion ? $audience->observacion : 'N/A' }}</div>
        <div class="field"><strong>Estado de la audiencia:</strong> {{ $audience->status->name ? $audience->status->name : 'N/A' }}</div>
    </div>
</body>
</html>
