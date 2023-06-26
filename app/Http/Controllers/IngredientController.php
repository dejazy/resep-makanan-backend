<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;

class IngredientController extends Controller
{
    use ApiResponser;

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:categories,name']
        ]);

        $ingredient = Ingredient::create($request->all());

        return $this->successResponse($ingredient, 201);
    }

    public function delete(Ingredient $ingredient)
    {
        $ingredient->loadCount('recipes');

        if ($ingredient->recipes_count > 0) {
            return $this->errorResponse('Unprocessable action', 422, ['recipe' => 'Have recipes']);
        }

        $delete = $ingredient->delete();

        return $this->successResponse($delete);
    }

    public function list()
    {
        $ingredients = Ingredient::all();
        return $this->successResponse($ingredients);
    }
}
