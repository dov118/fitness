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
        Schema::create('periods', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique('period_name')->nullable(false)->default('')->comment('Nom du cycle');

            $table->dateTime('start')->unique('start')->nullable(false)->default(now())->comment('Date de début du cycle');
            $table->dateTime('stop')->unique('stop')->nullable(false)->default(now()->add('days', 5))->comment('Date de fin du cycle');

            $table->timestamps();

            $table->comment('Cycle d\'exercices');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periods');
    }
};
