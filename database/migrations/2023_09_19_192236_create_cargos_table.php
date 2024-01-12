<?php

use App\Enums\NivelCargoEnum;
use App\Enums\TipoCargoEnum;
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
        Schema::create('cargos', function (Blueprint $table) {

            $table->unsignedInteger('id')->primary();
            $table->unsignedTinyInteger('nivel');
            $table->unsignedTinyInteger('tipo');
            $table->string('nombre', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargos');
    }
};
