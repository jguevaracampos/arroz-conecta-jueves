<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telefono')->nullable()->after('email');
            $table->string('departamento')->nullable()->after('telefono');
            $table->string('municipio')->nullable()->after('departamento');
            $table->string('vereda')->nullable()->after('municipio');
            $table->string('direccion')->nullable()->after('vereda');
            $table->string('avatar')->nullable()->after('direccion');
            $table->string('rol')->default('agricultor')->after('avatar'); // administrador, agricultor, tecnico
            $table->timestamp('data_policy_accepted_at')->nullable()->after('rol');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'telefono',
                'departamento',
                'municipio',
                'vereda',
                'direccion',
                'avatar',
                'rol',
                'data_policy_accepted_at',
            ]);
        });
    }
};
