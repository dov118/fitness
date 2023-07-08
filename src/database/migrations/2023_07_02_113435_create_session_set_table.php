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
            $table->foreignId('session_id')->constrained('sessions');

            $table->foreignId('set_id')->constrained('sets');

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
