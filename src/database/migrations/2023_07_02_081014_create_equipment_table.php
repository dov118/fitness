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
        Schema::create('equipment', function (Blueprint $table) { // TODO à changer en equipments
            $table->id();

            $table->string('name', 64)->nullable(false)->default('')
                ->unique('equipment_name')
                ->comment('Nom du materiel');
            $table->float('weight')->nullable(false)->default(1.5)->comment('Poid');

            $table->integer('full2_5')->nullable(false)->default(0)->comment('Nombre d\'haltère de 2.5kg nécéssaire');
            $table->integer('full5')->nullable(false)->default(0)->comment('Nombre d\'haltère de 5kg nécéssaire');
            $table->integer('full7_5')->nullable(false)->default(0)->comment('Nombre d\'haltère de 7.5kg nécéssaire');

            $table->integer('empty')->nullable(false)->default(1)->comment('Nombre d\'haltère vide nécéssaire');
            $table->integer('ez')->nullable(false)->default(0)->comment('Nombre de barre EZ nécéssaire');
            $table->integer('barre')->nullable(false)->default(0)->comment('Nombre de barre simple nécéssaire');

            $table->integer('0_5')->nullable(false)->default(0)->comment('Nombre de poid 0.5kg');
            $table->integer('1_25')->nullable(false)->default(0)->comment('Nombre de poid 1.25kg');
            $table->integer('2_5')->nullable(false)->default(0)->comment('Nombre de poid 2.5kg');
            $table->integer('5_0')->nullable(false)->default(0)->comment('Nombre de poid 5kg');

            $table->timestamps();

            $table->comment('Materiel de musculation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
