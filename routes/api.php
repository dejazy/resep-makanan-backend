<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RecipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('categories')->group(function() {
    Route::get('/', [CategoryController::class, 'list']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::delete('/{category}', [CategoryController::class, 'delete']);
    Route::put('/{category}', [CategoryController::class, 'update']);
});

Route::prefix('ingredients')->group(function() {
    Route::get('/', [IngredientController::class, 'list']);
    Route::post('/', [IngredientController::class, 'store']);
    Route::delete('{ingredient}', [IngredientController::class, 'delete']);
    Route::put('{ingredient}', [IngredientController::class, 'update']);
});

Route::prefix('recipes')->group(function() {
    Route::get('/', [RecipeController::class, 'list']);
    Route::post('/', [RecipeController::class, 'store']);
    Route::get('{recipe}', [RecipeController::class, 'get']);
    Route::put('{recipe}', [RecipeController::class, 'update']);
    Route::delete('{recipe}', [RecipeController::class, 'delete']);
});