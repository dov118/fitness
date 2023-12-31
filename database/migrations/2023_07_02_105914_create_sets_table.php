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
        Schema::create('sets', function (Blueprint $table) {
            $table->id();

            $table->integer('index')
                ->nullable(false)->default(1)
                ->comment('Index de la série pour l\'exercice');

            $table->integer('target')
                ->nullable(false)->default(1)
                ->comment('Nombre de répétitions cible');
            $table->integer('limit')
                ->nullable(false)->default(1)
                ->comment('Nombre de répétitions limite');
            $table->integer('min')
                ->nullable(false)->default(1)
                ->comment('Nombre de répétitions minimum');
            $table->integer('max')
                ->nullable(false)->default(1)
                ->comment('Nombre de répétitions maximum');

            $table->integer('left')
                ->nullable(false)->default(1)
                ->comment('Nombre de répétitions à gauche');
            $table->boolean('left_failure')
                ->nullable(false)->default(true)
                ->comment('Côté gauche à l\'échec');
            $table->integer('right')
                ->nullable(false)->default(1)
                ->comment('Nombre de répétitions à droite');
            $table->boolean('right_failure')
                ->nullable(false)->default(true)
                ->comment('Côté droit à l\'échec');

            $table->float('weight')
                ->nullable(false)->default(1.5)
                ->comment('Poid de la série');

            $table->longText('comment')
                ->nullable(false)
                ->comment('Commentaire sur la série');

            $table->integer('order')
                ->nullable(false)->default(1)
                ->comment('Ordre d\'execution');

            $table->dateTime('start')
                ->nullable(false)->default(now())
                ->comment('Début de l\'étape');
            $table->dateTime('stop')
                ->nullable(false)->default(now()->add('minutes', 2))
                ->comment('Fin de l\'étape');
            $table->float('duration')
                ->nullable(false)->default(27)
                ->comment('Durée de l\'étape');

            $table->boolean('warm_session')
                ->nullable(false)->default(false)
                ->comment('Si c\'est l\'echauffement de la séance');
            $table->boolean('warm_set')
                ->nullable(false)->default(false)
                ->comment('Si c\'est l\'echauffement d\'un groupe musculaire');
            $table->boolean('rest')
                ->nullable(false)->default(true)
                ->comment('Si c\'est une pause');

            $table->foreignId('equipment_id')->constrained('equipment');
            $table->foreignId('exercise_id')->constrained('exercises');
            $table->foreignId('session_id')->constrained('sessions');

            $table->timestamps();

            $table->comment('Etapes de séance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sets');
    }
};
