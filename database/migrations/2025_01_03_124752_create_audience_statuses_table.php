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
        Schema::create('audience_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre del estado
            $table->string('description')->nullable(); // Descripción opcional
            $table->string('color')->nullable();
            $table->boolean('activo')->default(true); // Estado activo/inactivo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audience_statuses');
    }
};
