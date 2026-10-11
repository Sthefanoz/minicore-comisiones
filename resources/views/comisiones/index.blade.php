@extends('layouts.app')

@section('content')
    <div class="card">
        <h2>Filtrar ventas por rango de fechas</h2>

        @if ($errors->any())
            <div class="errores">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form class="filtro" method="GET" action="{{ route('comisiones.index') }}">
            <label>Fecha inicio
                <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio', $fechaInicio) }}" required>
            </label>
            <label>Fecha fin
                <input type="date" name="fecha_fin" value="{{ old('fecha_fin', $fechaFin) }}" required>
            </label>
            <button type="submit">Calcular comisiones</button>
            <a class="btn btn-sec" href="{{ route('comisiones.index') }}">Limpiar</a>
        </form>
    </div>

    @if ($resultados)
        <div class="card">
            <h2>Resultados del {{ \Illuminate\Support\Carbon::parse($fechaInicio)->format('d/m/Y') }}
                al {{ \Illuminate\Support\Carbon::parse($fechaFin)->format('d/m/Y') }}</h2>
            <div class="tabla-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Vendedor</th>
                            <th class="num">N.º ventas</th>
                            <th class="num">Total vendido</th>
                            <th>Tramo aplicado</th>
                            <th class="num">% comisión</th>
                            <th class="num">Comisión</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($resultados as $fila)
                            <tr>
                                <td>{{ $fila['vendedor']->nombre }}</td>
                                <td class="num">{{ $fila['numero_ventas'] }}</td>
                                <td class="num">${{ number_format($fila['total_ventas'], 2) }}</td>
                                <td>
                                    @if ($fila['regla'])
                                        <span class="badge">{{ $fila['regla']->nombre }}</span>
                                    @else
                                        <span class="muted">Sin ventas</span>
                                    @endif
                                </td>
                                <td class="num">{{ number_format($fila['porcentaje'], 2) }}%</td>
                                <td class="num comision">${{ number_format($fila['comision'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Total</td>
                            <td class="num">{{ $resultados->sum('numero_ventas') }}</td>
                            <td class="num">${{ number_format($resultados->sum('total_ventas'), 2) }}</td>
                            <td></td>
                            <td></td>
                            <td class="num comision">${{ number_format($resultados->sum('comision'), 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @else
        <div class="card muted">Selecciona una fecha de inicio y una de fin para calcular las comisiones.
            Hay ventas de prueba entre el 01/01/2026 y el 11/10/2026.</div>
    @endif

    <div class="card">
        <h2>Reglas de comisión (según el total vendido en el periodo)</h2>
        <div class="tabla-wrap">
            <table>
                <thead>
                    <tr><th>Tramo</th><th class="num">Desde</th><th class="num">Hasta</th><th class="num">Porcentaje</th></tr>
                </thead>
                <tbody>
                    @foreach ($reglas as $regla)
                        <tr>
                            <td>{{ $regla->nombre }}</td>
                            <td class="num">${{ number_format($regla->monto_minimo, 2) }}</td>
                            <td class="num">{{ $regla->monto_maximo !== null ? '$' . number_format($regla->monto_maximo, 2) : 'En adelante' }}</td>
                            <td class="num">{{ number_format($regla->porcentaje, 2) }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
