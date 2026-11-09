<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sensores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('lote_id')->nullable()->constrained('lotes')->nullOnDelete();
            $table->string('codigo_sensor')->unique(); // p. ej. ESP8266-SALDANA-01
            $table->string('nombre');
            $table->string('tipo')->default('Capacitivo Humedad / Temperatura / pH');
            $table->string('estado')->default('activo'); // activo, inactivo, desconectado
            $table->unsignedInteger('bateria_porcentaje')->default(95);
            $table->timestamp('ultima_conexion')->nullable();
            $table->timestamps();
        });

        Schema::create('mediciones_sensor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sensor_id')->constrained('sensores')->cascadeOnDelete();
            $table->foreignId('lote_id')->nullable()->constrained('lotes')->nullOnDelete();
            $table->decimal('humedad_suelo', 5, 2); // 68.00 %
            $table->decimal('humedad_aire', 5, 2)->default(75.00); // 75.00 %
            $table->decimal('temperatura', 5, 2)->default(28.00); // 28.00 °C
            $table->decimal('ph', 4, 2)->default(6.50); // 6.50
            $table->string('estado_humedad')->default('Adecuada'); // Adecuada, Baja, Alta
            $table->string('origen')->default('iot_nodemcu'); // iot_nodemcu, simulado
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mediciones_sensor');
        Schema::dropIfExists('sensores');
    }
};
