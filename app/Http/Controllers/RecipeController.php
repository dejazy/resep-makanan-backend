<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    use ApiResponser;

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required'],
            'time' => ['required'],
            'portion' => ['required'],
            'description' => ['required'],
            'photo' => ['required', 'file', 'image'],
            'steps' => ['required', 'array'],
            'ingredients.*.id' => ['required', 'exists:ingredients,id'],
            'ingredients.*.measurement' => ['required'],
        ]);

        $data = $request->collect()->except(['ingredients', 'photo'])->toArray();

        $data['photo'] = $request->file('photo')->store('recipes', 'upload');

        $recipe = Recipe::create($data);

        $recipe->ingredients()->sync($this->constructIngredients($request->input('ingredients')));

        return $this->successResponse($recipe, 201);
    }

    public function delete(Recipe $recipe)
    {
        $delete = $recipe->delete();

        return $this->successResponse($delete);
    }

    public function update(Request $request, Recipe $recipe)
    {
        $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required'],
            'time' => ['required'],
            'portion' => ['required'],
            'description' => ['required'],
            'photo' => ['image'],
            'steps' => ['required', 'array'],
            'ingredients' => ['required', 'array'],
            'ingredients.*.id' => ['required', 'exists:ingredients,id'],
            'ingredients.*.measurement' => ['required'],
        ]);

        $data = $request->collect()->except(['ingredients', 'photo']);

        $updatedData = collect($recipe)->merge($data)->toArray();

        if ($request->hasFile('photo'))
            $updatedData['photo'] = $request->file('photo')->store('recipes', 'upload');

        $update = $recipe->update($updatedData);

        $recipe->ingredients()->sync($this->constructIngredients($request->input('ingredients')));

        return $this->successResponse($update);
    }

    public function get(Recipe $recipe)
    {
        return $this->successResponse($recipe);
    }

    public function list(Request $request)
    {
        $request->validate([
            'category_id' => [],
            'ingredients' => ['array'],
        ]);

        $recipes = Recipe::query();

        if ($request->filled('category_id'))
            $recipes = $recipes->where('category_id', $request->input('category_id'));

        if ($request->filled('ingredients')) {
            foreach ($request->input('ingredients') as $ingredient) {
                $recipes = $recipes->whereRelation('recipes', 'id', $ingredient);
            }
        }

        $recipes = $recipes->get();

        return $this->successResponse($recipes);
    }

    private function constructIngredients(array $ingredients)
    {
        $newData = [];
        foreach ($ingredients as $ingredient) {
            $newData[$ingredient['id']] = ['measurement' => $ingredient['measurement']];
        }
        return $newData;
    }
}
