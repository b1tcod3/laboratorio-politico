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
        Schema::create('comunidads', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->timestamps();

            $table->string('nombre',80);
            $table->unsignedInteger('centro_electoral_id');
            $table->foreign('centro_electoral_id')->references('id')->on('centro_electorals')->onUpdate('cascade')->onDelete('cascade');

            $table->unique(['nombre','centro_electoral_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comunidads');
    }
};
