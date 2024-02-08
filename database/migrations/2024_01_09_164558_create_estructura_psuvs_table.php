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
        Schema::create('estructura_psuvs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('persona_id');
            $table->foreign('persona_id')->references('id')->on('personas');

            $table->unsignedInteger('cargo_id');
            $table->foreign('cargo_id')->references('id')->on('cargos');

            $table->unsignedTinyInteger('municipio_id')->nullable();
            $table->foreign('municipio_id')->references('id')->on('municipios');

            $table->unsignedSmallInteger('parroquia_id')->nullable();
            $table->foreign('parroquia_id')->references('id')->on('parroquias');

            $table->unsignedInteger('centro_electoral_id')->nullable();
            $table->foreign('centro_electoral_id')->references('id')->on('centro_electorals');

            $table->unsignedInteger('comunidad_id')->nullable();
            $table->foreign('comunidad_id')->references('id')->on('comunidads');

            $table->unsignedInteger('calle_id')->nullable();
            $table->foreign('calle_id')->references('id')->on('calles');

            $table->boolean('verificado')->nullable();
            $table->boolean('validado')->nullable();

            $table->unique(['cargo_id','comunidad_id']);
            $table->unique(['cargo_id','calle_id']);
            $table->unique(['cargo_id','centro_electoral_id']);
            $table->unique(['persona_id','municipio_id']);
            $table->unique(['persona_id','parroquia_id']);
            $table->unique(['persona_id','centro_electoral_id']);
            $table->unique(['persona_id','comunidad_id']);
            $table->unique(['persona_id','calle_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estructura_psuvs');
    }
};
