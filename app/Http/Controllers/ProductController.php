<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use Auth;

class ProductController extends Controller
{
    public function index()
    {
        return view("product.add-edit");
    }
    public function addProduct(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|string|max:255',
        ]);
        $product = new ProductModel();
        $product->image = $request->image;
        $product->name = $request->name;
        $product->import_price = $request->import_price;
        $product->retail_price = $request->retail_price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->save();
        return response()->json(['message' => 'Product added successfully']);
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