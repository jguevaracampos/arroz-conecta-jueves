<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('categoria'); // Plagas y enfermedades, Fertilizantes, Siembra, Riego, Maquinaria, Cosecha, Experiencias agrícolas
            $table->string('titulo');
            $table->text('contenido');
            $table->string('imagen')->nullable();
            $table->unsignedInteger('likes_count')->default(0);
            $table->boolean('reportada')->default(false);
            $table->timestamps();
        });

        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('publicacion_id')->constrained('publicaciones')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('contenido');
            $table->timestamps();
        });

        Schema::create('reacciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('publicacion_id')->constrained('publicaciones')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('tipo')->default('me_gusta');
            $table->timestamps();

            $table->unique(['publicacion_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reacciones');
        Schema::dropIfExists('comentarios');
        Schema::dropIfExists('publicaciones');
    }
};
