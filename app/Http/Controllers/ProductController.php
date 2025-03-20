<?php

namespace App\Http\Controllers;

use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use App\Models\ProductModel;
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
        $warehouse = WarehouseModel::all()->pluck('name', 'id');
        $category = CategoryModel::all()->pluck('name', 'id');
        return view("product.add-edit", compact('category', 'warehouse'));
    }
    public function store(Request $request){
        $product = $this->productService->store($request);
        return $product ? $this->success('Product created successfully', $product) : $this->error('Product not created', 500);
    }
    public function getProducts(){
        $products = ProductModel::all();
        return response()->json($products);
    }
    public function getProductById(Request $request){
        $product = ProductModel::find($request->id);
        return response()->json($product);
    }
    public function editProduct(Request $request){
        $product = ProductModel::find($request->id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->save();
        return response()->json(['message' => 'Product updated successfully']);
    }
}
