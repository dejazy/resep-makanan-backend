<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Ingredient;

class IngredientControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_create_ingredient(): void
    {
        $response = $this->post('/api/ingredients', [
            'name' => 'Telur'
        ]);

        $response->assertStatus(201);
    }

    public function test_list_ingredient(): void
    {
        Ingredient::factory()->count(2)->create();

        $response = $this->get('/api/ingredients');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    public function test_delete_ingredient(): void
    {
        $ingredientOne = Ingredient::factory()->create();
        $ingredientTwo = Ingredient::factory()->create();

        $response = $this->get('/api/ingredients');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');

        $responseOne = $this->delete('/api/ingredients/' . $ingredientOne->id);
        $responseTwo = $this->delete('/api/ingredients/' . $ingredientTwo->id);

        $responseOne->assertStatus(200);
        $responseTwo->assertStatus(200);

        $response = $this->get('/api/ingredients');
        $response->assertJsonCount(0, 'data');
    }
}
