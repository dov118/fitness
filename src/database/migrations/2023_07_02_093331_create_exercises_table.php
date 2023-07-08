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
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();

            $table->string('name', 64)->unique('exercise_name')->nullable(false)->default('')->comment('Nom de l\'exercice');

            $table->longText('guideline')->nullable(false)->comment('Mouvements, instructions, ...');

            $table->integer('heavy_min')->nullable(false)->default(1)->comment('Nombre de répétitions minimum en lourd');
            $table->integer('heavy_max')->nullable(false)->default(1)->comment('Nombre de répétitions maximum en lourd');
            $table->integer('light_min')->nullable(false)->default(1)->comment('Nombre de répétitions minimum en léger');
            $table->integer('light_max')->nullable(false)->default(1)->comment('Nombre de répétitions maximum en léger');

            $table->float('duration')->nullable(false)->default(1)->comment('Durée d\'une répétition (ou couple pour bilatéral)');

            $table->timestamps();

            $table->comment('Exercices de musculation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('exercises');
        Schema::enableForeignKeyConstraints();
    }
};
