<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReglaComision extends Model
{
    protected $table = 'reglas_comision';

    protected $fillable = ['nombre', 'monto_minimo', 'monto_maximo', 'porcentaje'];

    protected $casts = [
        'monto_minimo' => 'decimal:2',
        'monto_maximo' => 'decimal:2',
        'porcentaje' => 'decimal:2',
    ];

    /**
     * Devuelve el tramo que aplica a un total de ventas: monto_minimo <= total < monto_maximo.
     */
    public static function paraMonto(float $total): ?self
    {
        return static::where('monto_minimo', '<=', $total)
            ->where(fn ($q) => $q->whereNull('monto_maximo')->orWhere('monto_maximo', '>', $total))
            ->orderByDesc('monto_minimo')
            ->first();
    }
}
