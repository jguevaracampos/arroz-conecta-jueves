<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('finca_id')->constrained('fincas')->cascadeOnDelete();
            $table->string('nombre');
            $table->decimal('area_hectareas', 8, 2)->default(1.0);
            $table->string('tipo_arroz')->default('Riego'); // Riego, Secano
            $table->foreignId('variedad_arroz_id')->nullable()->constrained('variedades_arroz')->nullOnDelete();
            $table->string('variedad_nombre')->nullable();
            $table->date('fecha_siembra')->nullable();
            $table->string('estado')->default('Activo'); // Activo, En preparación, Cosechado, En descanso
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lotes');
    }
};
