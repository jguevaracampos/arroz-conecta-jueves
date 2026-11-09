<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variedades_arroz', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedInteger('dias_ciclo')->default(125);
            $table->text('descripcion')->nullable();
            $table->decimal('rendimiento_estimado_ton', 5, 2)->default(7.5);
            $table->timestamps();
        });

        Schema::create('etapas_fenologicas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('orden');
            $table->string('nombre');
            $table->string('rango_dias');
            $table->unsignedInteger('porcentaje_inicio');
            $table->unsignedInteger('porcentaje_fin');
            $table->text('descripcion')->nullable();
            $table->text('recomendaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('etapas_fenologicas');
        Schema::dropIfExists('variedades_arroz');
    }
};
