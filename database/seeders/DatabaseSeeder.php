<?php

namespace Database\Seeders;

use App\Models\ReglaComision;
use App\Models\Vendedor;
use App\Models\Venta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $reglas = [
            ['nombre' => 'Tramo 1', 'monto_minimo' => 0,     'monto_maximo' => 1000,  'porcentaje' => 3],
            ['nombre' => 'Tramo 2', 'monto_minimo' => 1000,  'monto_maximo' => 5000,  'porcentaje' => 5],
            ['nombre' => 'Tramo 3', 'monto_minimo' => 5000,  'monto_maximo' => 10000, 'porcentaje' => 8],
            ['nombre' => 'Tramo 4', 'monto_minimo' => 10000, 'monto_maximo' => null,  'porcentaje' => 10],
        ];
        foreach ($reglas as $regla) {
            ReglaComision::create($regla);
        }

        $vendedores = collect([
            ['nombre' => 'Ana Torres',     'email' => 'ana.torres@minicore.test'],
            ['nombre' => 'Carlos Mendoza', 'email' => 'carlos.mendoza@minicore.test'],
            ['nombre' => 'Lucía Paredes',  'email' => 'lucia.paredes@minicore.test'],
            ['nombre' => 'Miguel Herrera', 'email' => 'miguel.herrera@minicore.test'],
            ['nombre' => 'Sofía Vega',     'email' => 'sofia.vega@minicore.test'],
        ])->map(fn ($v) => Vendedor::create($v));

        // Semilla fija: los datos son siempre los mismos y los resultados se pueden verificar.
        mt_srand(2026);
        $productos = ['Laptop', 'Monitor', 'Impresora', 'Teclado', 'Licencia software', 'Servidor', 'Router', 'Tablet'];
        $inicio = Carbon::create(2026, 1, 1);

        foreach ($vendedores as $indice => $vendedor) {
            // Cada vendedor tiene un volumen distinto para que caigan en tramos diferentes.
            $cantidad = [8, 20, 35, 50, 14][$indice];
            for ($i = 0; $i < $cantidad; $i++) {
                Venta::create([
                    'vendedor_id' => $vendedor->id,
                    'fecha' => $inicio->copy()->addDays(mt_rand(0, 283))->toDateString(),
                    'monto' => mt_rand(5000, 120000) / 100,
                    'descripcion' => $productos[mt_rand(0, count($productos) - 1)],
                ]);
            }
        }
    }
}
