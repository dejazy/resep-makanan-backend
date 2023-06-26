<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => Str::random(10),
            'time' => rand(1, 10),
            'portion' => rand(1, 10),
            'description' => Str::random(200),
            'photo' => Str::random(10),
            'steps' => ["Step 1", "Step 2"]
        ];
    }
}
