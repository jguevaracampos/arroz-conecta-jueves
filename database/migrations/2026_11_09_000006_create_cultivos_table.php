<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cultivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('lote_id')->constrained('lotes')->cascadeOnDelete();
            $table->foreignId('variedad_arroz_id')->nullable()->constrained('variedades_arroz')->nullOnDelete();
            $table->string('nombre_cultivo');
            $table->string('variedad_nombre');
            $table->date('fecha_siembra');
            $table->date('fecha_estimada_cosecha')->nullable();
            $table->decimal('area_sembrada', 8, 2)->default(1.0);
            $table->string('etapa_actual')->default('Germinación');
            $table->unsignedInteger('progreso_porcentaje')->default(5);
            $table->unsignedInteger('dias_transcurridos')->default(0);
            $table->string('estado')->default('Activo'); // Activo, En seguimiento, Cosechado, Cancelado
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cultivos');
    }
};
