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
        Schema::create('ingredient_recipe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingredient_id')->references('id')->on('ingredients');
            $table->foreignId('recipe_id')->references('id')->on('recipes');
            $table->string('measurement');
            $table->timestamps();

            $table->unique(['ingredient_id', 'recipe_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient_recipe');
    }
};
