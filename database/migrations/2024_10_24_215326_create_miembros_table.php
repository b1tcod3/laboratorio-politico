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
        Schema::create('miembros', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('cargo_id')
                ->constrained(
                    table: 'cargos'
                )
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('persona_id')
                ->constrained(
                    table: 'personas'
                )
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->boolean('suplente')->default(0);
            $table->boolean('active')->default(1);

            $table->unsignedTinyInteger('municipio_id')->nullable();
            $table->foreign('municipio_id')->references('id')->on('municipios');

            $table->unsignedSmallInteger('parroquia_id')->nullable();
            $table->foreign('parroquia_id')->references('id')->on('parroquias');

            $table->unsignedInteger('centro_electoral_id')->nullable();
            $table->foreign('centro_electoral_id')->references('id')->on('centro_electorals');

            $table->foreignId('comunidad_id')
                ->nullable()
                ->constrained(
                    table: 'comunidads'
                )
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('calle_id')
                ->nullable()
                ->constrained(
                    table: 'calles'
                )
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unique(['cargo_id', 'persona_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('miembros');
    }
};
