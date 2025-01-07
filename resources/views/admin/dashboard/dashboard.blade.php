@extends('admin.layout.general')

@section('contenido')
<div class="container mt-4">
    <h1 class="mb-4">Estadísticas de Audiencias</h1>
    <div class="row">
        <!-- Iterar sobre los estados -->
        @foreach ($statuses as $status)
        <div class="col-md-4">
            <div class="card shadow-lg border-secondary mb-4">
                <div class="card-body">
                    <h5 class="card-title" style="color: {{ $status['color'] }}">{{ $status['name'] }}</h5>
                    <p class="card-text">
                        <strong>Total:</strong> {{ $status['count'] }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Tabla con detalles -->
    <h2 class="mt-5">Resumen por Estado</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Estado</th>
                <th>Total</th>
                <th>Color</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($statuses as $status)
            <tr>
                <td>{{ $status['name'] }}</td>
                <td>{{ $status['count'] }}</td>
                <td>
                    <span class="badge" style="background-color: {{ $status['color'] }}; color: #fff;">
                        {{ $status['name'] }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
