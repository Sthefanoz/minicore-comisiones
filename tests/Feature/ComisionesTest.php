<?php

namespace Tests\Feature;

use App\Models\ReglaComision;
use App\Models\Vendedor;
use App\Services\CalculadoraComisiones;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComisionesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        ReglaComision::create(['nombre' => 'Tramo 1', 'monto_minimo' => 0, 'monto_maximo' => 1000, 'porcentaje' => 3]);
        ReglaComision::create(['nombre' => 'Tramo 2', 'monto_minimo' => 1000, 'monto_maximo' => null, 'porcentaje' => 5]);
    }

    public function test_solo_suma_ventas_dentro_del_rango_y_aplica_el_tramo(): void
    {
        $vendedor = Vendedor::create(['nombre' => 'Ana', 'email' => 'ana@test.com']);
        $vendedor->ventas()->create(['fecha' => '2026-03-01', 'monto' => 600]);
        $vendedor->ventas()->create(['fecha' => '2026-03-31', 'monto' => 400]);
        $vendedor->ventas()->create(['fecha' => '2026-04-01', 'monto' => 9999]); // fuera del rango

        $fila = (new CalculadoraComisiones)->calcular('2026-03-01', '2026-03-31')->first();

        // 1000 cae en el Tramo 2 (el límite inferior es inclusivo)
        $this->assertSame(1000.0, $fila['total_ventas']);
        $this->assertSame(5.0, $fila['porcentaje']);
        $this->assertSame(50.0, $fila['comision']);
    }

    public function test_vendedor_sin_ventas_tiene_comision_cero(): void
    {
        Vendedor::create(['nombre' => 'Luis', 'email' => 'luis@test.com']);

        $fila = (new CalculadoraComisiones)->calcular('2026-01-01', '2026-01-31')->first();

        $this->assertSame(0.0, $fila['comision']);
        $this->assertNull($fila['regla']);
    }

    public function test_valida_que_la_fecha_fin_no_sea_anterior(): void
    {
        $this->get('/?fecha_inicio=2026-05-10&fecha_fin=2026-05-01')
            ->assertSessionHasErrors('fecha_fin');
    }

    public function test_la_pagina_muestra_resultados(): void
    {
        $vendedor = Vendedor::create(['nombre' => 'Ana Torres', 'email' => 'ana@test.com']);
        $vendedor->ventas()->create(['fecha' => '2026-03-10', 'monto' => 500]);

        $this->get('/?fecha_inicio=2026-03-01&fecha_fin=2026-03-31')
            ->assertOk()
            ->assertSee('Ana Torres')
            ->assertSee('$15.00');
    }
}
