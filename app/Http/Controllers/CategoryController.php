<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponser;

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:categories,name']
        ]);

        $category = Category::create($request->all());

        return $this->successResponse($category, 201);
    }

    public function delete(Category $category)
    {
        $category->loadCount('recipes');

        if ($category->recipes_count > 0) {
            return $this->errorResponse('Unprocessable action', 422, ['recipe' => 'Have recipes']);
        }

        $delete = $category->delete();

        return $this->successResponse($delete);
    }

    public function list()
    {
        $categories = Category::all();
        return $this->successResponse($categories);
    }
}
