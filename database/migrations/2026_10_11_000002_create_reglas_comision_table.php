<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reglas_comision', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('monto_minimo', 12, 2);
            // null = sin tope superior (último tramo)
            $table->decimal('monto_maximo', 12, 2)->nullable();
            $table->decimal('porcentaje', 5, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reglas_comision');
    }
};
