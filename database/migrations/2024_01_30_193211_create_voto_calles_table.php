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
        Schema::create('voto_calles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedTinyInteger('tipo');
            $table->unsignedTinyInteger('hora_votacion');
            $table->boolean('verificado')->nullable();
            $table->boolean('validado')->nullable();

            $table->unsignedInteger('calle_id')->nullable();
            $table->foreign('calle_id')->references('id')->on('calles');

            $table->unsignedBigInteger('persona_id')->unique();
            $table->foreign('persona_id')->references('id')->on('personas');

            $table->unsignedBigInteger('movilizado_por_id')->unique();
            $table->foreign('movilizado_por_id')->references('id')->on('personas');

            $table->unique(['persona_id','calle_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voto_calles');
    }
};
