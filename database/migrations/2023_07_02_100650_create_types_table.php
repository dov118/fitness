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
        Schema::create('types', function (Blueprint $table) {
            $table->id();

            $table->string('name', 64)
                ->unique('type_name')
                ->nullable(false)->default('')
                ->comment('Nom du type de scéance');

            $table->boolean('light')
                ->nullable(false)->default(true)
                ->comment('Scéance légère');
            $table->boolean('heavy')
                ->nullable(false)->default(false)
                ->comment('Scéance lourde');

            $table->timestamps();

            $table->comment('Types de scéance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('types');
    }
};
