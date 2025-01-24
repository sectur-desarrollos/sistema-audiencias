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
        Schema::create('audiences', function (Blueprint $table) {
            $table->id();
            $table->string('folio');
            $table->string('email')->nullable();
            $table->string('nombre');
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->longText('asunto');
            $table->longText('observacion')->nullable();
            $table->time('hora_llegada');
            $table->date('fecha_llegada');
            $table->string('telefono')->nullable();
            $table->string('cargo')->nullable();
            $table->foreignId('contact_type_id')->constrained('contact_types');
            $table->foreignId('dependency_id')->nullable()->constrained('dependencies');
            $table->foreignId('audience_status_id')->nullable()->constrained('audience_statuses');
            $table->foreignId('state_id')->nullable()->constrained('states');
            $table->foreignId('municipality_id')->nullable()->constrained('municipalities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audiences');
    }
};
