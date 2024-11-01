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
        Schema::create('data_comunidads', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedTinyInteger('tipo');
            $table->foreignId('comunidad_id')
                ->nullable()
                ->constrained(
                    table: 'comunidads'
                )
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->decimal('value_numeric', $precision = 8, $scale = 2)->nullable();
            $table->string('value_text')->nullable();
            $table->unsignedTinyInteger('value_enum')->nullable();

            $table->unique(['tipo', 'comunidad_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_comunidads');
    }
};
