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
        Schema::create('historial_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('usuario_id'); // Solo almacenará el número de usuario
            $table->string('usuario_nombre');
            $table->string('modulo');
            $table->string('accion');
            $table->string('lugar');
            $table->longText('informacion');
            $table->timestamp('fecha_accion')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_logs');
    }
};
