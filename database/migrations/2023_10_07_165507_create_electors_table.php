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
        Schema::create('electores', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedInteger('centro_electoral_id');
            $table->unsignedBigInteger('persona_id')->unique();

            $table->foreign('centro_electoral_id')->references('id')->on('centro_electorals')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('persona_id')->references('id')->on('personas')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electors');
    }
};
