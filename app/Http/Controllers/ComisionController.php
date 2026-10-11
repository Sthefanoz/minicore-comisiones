<?php

namespace App\Http\Controllers;

use App\Models\ReglaComision;
use App\Services\CalculadoraComisiones;
use Illuminate\Http\Request;

class ComisionController extends Controller
{
    public function index(Request $request, CalculadoraComisiones $calculadora)
    {
        $datos = $request->validate([
            'fecha_inicio' => ['nullable', 'date'],
            'fecha_fin' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
        ], [
            'fecha_fin.after_or_equal' => 'La fecha fin debe ser igual o posterior a la fecha inicio.',
        ]);

        $fechaInicio = $datos['fecha_inicio'] ?? null;
        $fechaFin = $datos['fecha_fin'] ?? null;

        $resultados = ($fechaInicio && $fechaFin)
            ? $calculadora->calcular($fechaInicio, $fechaFin)
            : null;

        return view('comisiones.index', [
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'resultados' => $resultados,
            'reglas' => ReglaComision::orderBy('monto_minimo')->get(),
        ]);
    }
}
