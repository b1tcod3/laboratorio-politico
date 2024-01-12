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
        Schema::create('centro_electorals', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->string('nombre',80);
            $table->boolean('estatus');
            $table->unsignedSmallInteger('parroquia_id');

            $table->foreign('parroquia_id')->references('id')->on('parroquias');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centro_electorals');
    }
};
