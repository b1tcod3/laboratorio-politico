<?php

use App\Enums\CircuitoEnum;
use App\Enums\EjeEnum;
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
        Schema::create('municipios', function (Blueprint $table) {
            $table->unsignedTinyInteger('id')->primary();

            $table->string('nombre',50);
            $table->enum('eje', EjeEnum::values());
            $table->enum('circuito', CircuitoEnum::values());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('municipios');
    }
};
