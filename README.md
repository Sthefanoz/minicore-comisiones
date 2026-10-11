# MiniCore: Cálculo de Comisiones (Laravel MVC)

Aplicación en Laravel que filtra las ventas por un rango de fechas y calcula la comisión de cada vendedor según tramos de monto.

**Demo en línea:** https://minicore-comisiones.onrender.com

> Está en el plan gratuito de Render: si no ha tenido visitas recientes, la primera carga puede tardar unos 50 segundos.

## Lógica del core

1. El usuario elige **fecha inicio** y **fecha fin**.
2. Para cada vendedor se suman sus ventas dentro de ese rango (ambas fechas incluidas).
3. Con ese total se busca la regla que aplica (`monto_minimo <= total < monto_maximo`).
4. **Comisión = total vendido × porcentaje / 100**

| Tramo | Desde | Hasta | % |
|---|---|---|---|
| Tramo 1 | $0 | $1,000 | 3% |
| Tramo 2 | $1,000 | $5,000 | 5% |
| Tramo 3 | $5,000 | $10,000 | 8% |
| Tramo 4 | $10,000 | en adelante | 10% |

## Estructura MVC

| Capa | Archivo |
|---|---|
| Modelos | `app/Models/Vendedor.php`, `Venta.php`, `ReglaComision.php` |
| Lógica de cálculo | `app/Services/CalculadoraComisiones.php` |
| Controlador | `app/Http/Controllers/ComisionController.php` |
| Vistas | `resources/views/comisiones/index.blade.php`, `layouts/app.blade.php` |
| Ruta | `routes/web.php` (`GET /`) |
| Base de datos | `database/migrations/2026_10_11_*`, `database/seeders/DatabaseSeeder.php` |

Tablas: `vendedores` (1) ── (N) `ventas`; `reglas_comision` es independiente.

## Cómo ejecutarlo

Requisitos: PHP 8.3+ y Composer.

```bash
composer install
cp .env.example .env        # en Windows: copy .env.example .env
php artisan key:generate
php artisan migrate --seed  # crea database/database.sqlite con datos de prueba
php artisan serve
```

Abre http://127.0.0.1:8000. Los datos de prueba son 5 vendedores con ventas entre el 01/01/2026 y el 11/10/2026.

## Despliegue

Desplegado en Render con Docker (`Dockerfile`, `docker/entrypoint.sh` y `render.yaml`). Al arrancar, el contenedor crea la base de datos SQLite y carga los datos de prueba.

## Tests

```bash
php artisan test
```
