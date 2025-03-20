<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Traits\ResponseAPI;
use App\Http\Services\CategoryService;
use Auth;

class CategoryController extends Controller
{
    use ResponseAPI;

    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        return view("category.list");
    }

    public function store(Request $request)
    {
        $category = $this->categoryService->store($request);
        return $category ? $this->success('Category created successfully', $category) : $this->error('Category not created', 500);
    }

    public function getAll()
    {
        $categories = $this->categoryService->getAll();
        return $categories ? $this->success('Categories retrieved successfully', $categories) : $this->error('Categories not found', 404);
    }

    public function show(Request $request, $id)
    {
        $category = $this->categoryService->show($id);
        return $category ? $this->success('Category retrieved successfully', $category) : $this->error('Category not found', 404);
    }

    public function update(Request $request, $id)
    {
        $category = $this->categoryService->update($request, $id);
        return $category ? $this->success('Category updated successfully', $category) : $this->error('Category not found', 404);
    }

    public function destroy(Request $request, $id)
    {
        $category = $this->categoryService->destroy($id);
        return $category ? $this->success('Category deleted successfully', $category) : $this->error('Category not found', 404);
    }
}
