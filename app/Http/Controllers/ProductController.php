<?php

namespace App\Http\Controllers;

use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\WarehouseModel;
use App\Http\Services\ProductService;

class ProductController extends Controller
{
    use ResponseAPI;
    private $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function index()
    {
        return view('product.list');
    }
    public function addProductView(){
        $warehouse = WarehouseModel::all()->pluck('name', 'id');
        $category = CategoryModel::all()->pluck('name', 'id');
        return view("product.add-edit", compact('category', 'warehouse'));
    }
    public function editProductView($id){
        $product = $this->productService->show($id);
        $warehouse = WarehouseModel::all()->pluck('name', 'id');
        $category = CategoryModel::all()->pluck('name', 'id');
        return view("product.add-edit", compact( 'product', 'category', 'warehouse'));
    }
    public function store(Request $request){
        $product = $this->productService->store($request);
        return $product ? $this->success('Product created successfully', $product) : $this->error('Product not created', 500);
    }
    public function getAll(){
        $products = $this->productService->getAll();
        return $products ? $this->success('Products retrieved successfully', $products) : $this->error('Products not found', 404);
    }
    public function show(Request $request, $id){
        $product = $this->productService->show($id);
        return view('product.detail', compact('product'));
    }
    public function search(Request $request, $name){
        $product = $this->productService->search($name);
        return $product ? $this->success('Product retrieved successfully', $product) : $this->error('Product not found', 404);
    }
    public function update(Request $request, $id){
        $product = $this->productService->update($request, $id);
        return $product ? $this->success('Product updated successfully', $product) : $this->error('Product not updated', 500);
    }
}
