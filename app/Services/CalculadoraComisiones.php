<?php

namespace App\Services;

use App\Models\ReglaComision;
use App\Models\Vendedor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class CalculadoraComisiones
{
    /**
     * Calcula, para cada vendedor, el total vendido entre dos fechas (inclusive)
     * y la comisión según el tramo de la regla que corresponda a ese total.
     */
    public function calcular(string $fechaInicio, string $fechaFin): Collection
    {
        $vendedores = Vendedor::withSum(
            ['ventas as total_ventas' => fn ($q) => $this->enRango($q, $fechaInicio, $fechaFin)],
            'monto'
        )->withCount(
            ['ventas as numero_ventas' => fn ($q) => $this->enRango($q, $fechaInicio, $fechaFin)]
        )->orderBy('nombre')->get();

        return $vendedores->map(function (Vendedor $vendedor) {
            $total = (float) ($vendedor->total_ventas ?? 0);
            $regla = $total > 0 ? ReglaComision::paraMonto($total) : null;
            $porcentaje = $regla ? (float) $regla->porcentaje : 0.0;

            return [
                'vendedor' => $vendedor,
                'numero_ventas' => $vendedor->numero_ventas,
                'total_ventas' => $total,
                'regla' => $regla,
                'porcentaje' => $porcentaje,
                'comision' => round($total * $porcentaje / 100, 2),
            ];
        });
    }

    /**
     * Filtra por fecha (sin hora), incluyendo ambos extremos del rango.
     */
    private function enRango($query, string $fechaInicio, string $fechaFin)
    {
        return $query->whereDate('fecha', '>=', $fechaInicio)->whereDate('fecha', '<=', $fechaFin);
    }
}
