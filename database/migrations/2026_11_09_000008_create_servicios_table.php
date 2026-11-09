<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('titulo');
            $table->string('categoria'); // Alquiler de tractor, Preparación de terreno, Fumigación, Transporte de arroz, Recolección y cosecha, Mano de obra, Alquiler de maquinaria
            $table->text('descripcion');
            $table->decimal('precio', 12, 2)->nullable();
            $table->string('unidad_precio')->default('por hectárea'); // por hectárea, por viaje, por día, por hora, a convenir
            $table->string('departamento')->default('Tolima');
            $table->string('municipio')->default('Saldaña');
            $table->string('contacto_telefono');
            $table->string('contacto_whatsapp')->nullable();
            $table->string('imagen')->nullable();
            $table->boolean('disponible')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
