<?php

namespace Tests\Feature\Controllers;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class RecipeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_recipe(): void
    {
        $file = UploadedFile::fake()->image('avatar.jpg');
        $category = Category::factory()->create();
        $ingredient = Ingredient::factory()->create();

        $response = $this->post('/api/recipes', [
            'category_id' => $category->id,
            'name' => 'Telur Goreng',
            'time' => 10,
            'portion' => 1,
            'description' => 'Telur goreng desc',
            'photo' => $file,
            'steps' => ["Goreng", "Tiriskan"],
            'ingredients' => [['id' => $ingredient->id, 'measurement' => '1 buah']]
        ]);

        $response->assertStatus(201);
    }

    public function test_list_recipe(): void
    {
        $category = Category::factory()->create();
        Recipe::factory()->count(2)->for($category)->create();

        $response = $this->get('/api/recipes');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    public function test_delete_recipe(): void
    {
        $category = Category::factory()->create();
        $recipeOne = Recipe::factory()->for($category)->create();
        $recipeTwo = Recipe::factory()->for($category)->create();

        $response = $this->get('/api/recipes');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');

        $responseOne = $this->delete('/api/recipes/' . $recipeOne->id);
        $responseTwo = $this->delete('/api/recipes/' . $recipeTwo->id);

        $responseOne->assertStatus(200);
        $responseTwo->assertStatus(200);

        $response = $this->get('/api/recipes');
        $response->assertJsonCount(0, 'data');
    }

    // update

    public function test_update_recipe(): void
    {
        $category = Category::factory()->create();
        $recipe = Recipe::factory()
            ->for($category)
            ->hasAttached(
                Ingredient::factory()->count(3),
                ['measurement' => "1 butir"]
            )
            ->create();

        $file = UploadedFile::fake()->image('avatar.jpg');
        $category = Category::factory()->create();
        $ingredient = Ingredient::factory()->create();

        $response = $this->put('/api/recipes/' . $recipe->id, [
            'category_id' => $category->id,
            'name' => 'Telur Bakar',
            'time' => 10,
            'portion' => 1,
            'description' => 'Telur bakar desc',
            'photo' => $file,
            'steps' => ["Goreng", "Tiriskan"],
            'ingredients' => [['id' => $ingredient->id, 'measurement' => '1 buah']]
        ]);

        $this->assertDatabaseHas('recipes', [
            'name' => 'Telur Bakar',
        ]);

        $response->assertStatus(200);
    }

    // get

    public function test_get_recipe(): void
    {
        $category = Category::factory()->create();
        $recipe = Recipe::factory()
            ->for($category)
            ->hasAttached(
                Ingredient::factory()->count(3),
                ['measurement' => "1 butir"]
            )
            ->create();

        $response = $this->get('/api/recipes/' . $recipe->id);

        $response->assertStatus(200);
        $response->assertJsonIsObject('data');
    }
}
