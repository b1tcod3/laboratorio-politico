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
        Schema::create('data_centro_electorales', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('tipo');
            $table->unsignedInteger('centro_electoral_id');

            $table->decimal('value_numeric', $precision = 8, $scale = 2)->nullable();
            $table->string('value_text')->nullable();
            $table->unsignedTinyInteger('value_enum')->nullable();

            $table->foreign('centro_electoral_id')->references('id')->on('centro_electorals');

            $table->unique(['tipo','centro_electoral_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_centro_electorals');
    }
};
