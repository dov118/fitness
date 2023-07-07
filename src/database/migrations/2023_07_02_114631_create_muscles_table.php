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
        Schema::create('muscles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('group_id')->constrained('groups');

            $table->string('name', 64)->unique('muscle_name')->nullable(false)->default('')->comment('Nom du muscle');
            $table->integer('heavy_min')->nullable(false)->default(1)->comment('Nom de répétition mimimum en lourd');
            $table->integer('heavy_max')->nullable(false)->default(1)->comment('Nom de répétition maximum en lourd');
            $table->integer('light_min')->nullable(false)->default(1)->comment('Nom de répétition minimum en leger');
            $table->integer('light_max')->nullable(false)->default(1)->comment('Nom de répétition maximum en leger');
            $table->string('fiber_type', 255)->nullable(false)->default('')->comment('Type de fibre');
            $table->integer('max')->nullable(false)->default(1)->comment('Nomre maximum de répétition pour ce muscle');

            $table->timestamps();

            $table->comment('Muscles du corps');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('muscles');
    }
};
