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
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('persona_id')->unique();
            $table->foreign('persona_id')->references('id')->on('personas');

            $table->unsignedBigInteger('telefono_movil')->nullable();
            $table->unsignedBigInteger('telefono_movil_aux')->nullable();
            $table->string('email')->nullable();
            $table->string('cuenta_redes_sociales')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactos');
    }
};
