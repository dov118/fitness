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
        Schema::create('session_set', function (Blueprint $table) { // TODO revoir system de relation https://laravel.com/docs/10.x/eloquent-relationships#many-to-many
            $table->id();

            $table->foreignId('session_id')->constrained('sessions');

            $table->integer('order')->nullable(false)->default(1)->comment('Ordre d\'execution');

            $table->dateTime('start')->nullable(false)->default(now())->comment('Début de l\'étape');
            $table->dateTime('stop')->nullable(false)->default(now()->add('minutes', 2))->comment('Fin de l\'étape');
            $table->float('duration')->nullable(false)->default(27)->comment('Durée de l\'étape');

            $table->boolean('warm_session')->nullable(false)->default(false)->comment('Si c\'est l\'echauffement de la séance');
            $table->boolean('warm_set')->nullable(false)->default(false)->comment('Si c\'est l\'echauffement d\'un groupe musculaire');
            $table->boolean('rest')->nullable(false)->default(true)->comment('Si c\'est une pause');

            $table->foreignId('set_id')->constrained('sets');

            $table->timestamps();

            $table->comment('Etapes de séance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_set');
    }
};
