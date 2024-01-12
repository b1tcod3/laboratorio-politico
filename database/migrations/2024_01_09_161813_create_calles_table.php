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
        Schema::create('calles', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->timestamps();

            $table->string('nombre',80);

            $table->unsignedInteger('comunidad_id');
            $table->foreign('comunidad_id')->references('id')->on('comunidads')->onUpdate('cascade')->onDelete('cascade');

            $table->unique(['nombre','comunidad_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calles');
    }
};
