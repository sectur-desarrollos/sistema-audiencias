<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('audiences', function (Blueprint $table) {
            $table->time('hora_llegada')->nullable()->change();
        });
    }
    
    public function down(): void
    {
        Schema::table('audiences', function (Blueprint $table) {
            $table->time('hora_llegada')->nullable(false)->change();
        });
    }
};
