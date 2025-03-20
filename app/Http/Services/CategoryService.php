<?php

namespace App\Http\Services;

use App\Models\CategoryModel;
use App\Traits\ResponseAPI;
use App\Http\Resources\CategoryResource;

class CategoryService
{
    use ResponseAPI;

    public function show($id)
    {
        $category = CategoryModel::findorFail($id);
        if (!$category) 
        {
            return null;
        }
        return new CategoryResource($category);
    }

    public function getCategories()
    {
        $categories = CategoryModel::all();
        return CategoryResource::collection($categories);
    }

    public function store($request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $category = new CategoryModel();
        $category->name = $request->name;
        $category->save();
        return new CategoryResource($category);
    }

    public function update($request, $id)
    {
        $category = CategoryModel::findorFail($id);
        if (!$category) 
        {
            return null;
        }
        $category->name = $request->name;
        $category->save();
        return new CategoryResource($category);
    }

    public function destroy($id)
    {
        $category = CategoryModel::findorFail($id);
        if (!$category) 
        {
            return null;
        }
        $category->delete();
        return new CategoryResource($category);
    }
}
