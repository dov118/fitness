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
        Schema::create('exercise_muscle', function (Blueprint $table) {
            $table->foreignId('muscle_id')->constrained('muscles');
            $table->foreignId('exercise_id')->constrained('exercises');

            $table->float('intensity')->nullable(false)->default(1)->comment('Intensité du travail par l\'exercice');

            $table->comment('Liaison entre les muscles et les exercices');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_muscle');
    }
};
