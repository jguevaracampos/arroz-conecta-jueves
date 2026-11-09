<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guias_cultivo', function (Blueprint $table) {
            $table->id();
            $table->string('etapa'); // Preparación del terreno, Siembra, Riego, Fertilización, Control de plagas y enfermedades, Cosecha
            $table->string('titulo');
            $table->text('resumen');
            $table->longText('contenido');
            $table->string('icono')->nullable();
            $table->string('imagen')->nullable();
            $table->text('consejos_clave')->nullable();
            $table->timestamps();
        });

        Schema::create('consejos_semanales', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('consejo');
            $table->string('autor')->default('Ing. Agrónomo ArrozConecta');
            $table->string('etapa_relevante')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consejos_semanales');
        Schema::dropIfExists('guias_cultivo');
    }
};
