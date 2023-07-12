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
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('type_id')->constrained();

            $table->dateTime('date')
                ->unique('session_date')
                ->nullable(false)->default(now())
                ->comment('Date de la séance');

            $table->integer('order')
                ->nullable(false)->default(1)
                ->comment('Ordre de la séance dans la période');

            $table->foreignId('period_id')->constrained();

            $table->timestamps();

            $table->comment('Séance de sport');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
