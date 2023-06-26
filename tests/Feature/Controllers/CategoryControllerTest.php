<?php

namespace Tests\Feature\Controllers;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_create_category(): void
    {
        $response = $this->post('/api/categories', [
            'name' => 'Main Course'
        ]);

        $response->assertStatus(201);
    }

    public function test_list_category(): void
    {
        Category::factory()->count(2)->create();

        $response = $this->get('/api/categories');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    public function test_delete_category(): void
    {
        $categoryOne = Category::factory()->create();
        $categoryTwo = Category::factory()->create();

        $response = $this->get('/api/categories');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');

        $responseOne = $this->delete('/api/categories/' . $categoryOne->id);
        $responseTwo = $this->delete('/api/categories/' . $categoryTwo->id);

        $responseOne->assertStatus(200);
        $responseTwo->assertStatus(200);

        $response = $this->get('/api/categories');
        $response->assertJsonCount(0, 'data');
    }
}
