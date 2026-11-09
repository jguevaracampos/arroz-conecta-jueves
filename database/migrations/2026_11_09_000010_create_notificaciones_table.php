<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('cultivo_id')->nullable()->constrained('cultivos')->nullOnDelete();
            $table->string('tipo'); // fertilizacion, riego, humedad, seguimiento, cosecha, alerta
            $table->string('titulo');
            $table->text('mensaje');
            $table->string('nivel')->default('info'); // info, advertencia, peligro, exito
            $table->boolean('leida')->default(false);
            $table->timestamp('fecha_evento')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};
