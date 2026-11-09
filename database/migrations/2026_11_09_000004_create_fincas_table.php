<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fincas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nombre');
            $table->string('departamento');
            $table->string('municipio');
            $table->string('vereda')->nullable();
            $table->string('direccion')->nullable();
            $table->decimal('area_total', 8, 2)->default(0); // hectáreas
            $table->string('propietario')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fincas');
    }
};
