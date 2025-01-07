@extends('admin.audiences.pdf.pdf-template')

@section('pdf_name', 'Audiencia PDF.')

@section('contenido')
     <!-- Título -->
     <div class="title">
        {{ $audience->asunto }}
    </div>

            <!-- Tabla de Información -->
            <table class="companions-table">
                <!-- Primera fila: Persona principal -->
                <tr class="companion-row">
                    <td class="info-left">
                        <strong>{{ $audience->nombre }} {{ $audience->apellido_paterno }}
                            {{ $audience->apellido_materno }}</strong><br>
                        {{ $audience->cargo }}
                    </td>
                    <td class="info-right">
                        {{ $audience->telefono }}<br>
                        {{ $audience->email }}
                    </td>
                </tr>
                @foreach ($audience->companions as $companion)
                <tr class="companion-row">
                    <td class="info-left">
                        <strong>C. {{ $companion->nombre }}</strong><br>
                        {{ $companion->cargo }}
                    </td>
                    <td class="info-right">
                        {{ $companion->telefono }}<br>
                        {{ $companion->email }}
                    </td>
                </tr>
                @endforeach
            </table>
@endsection