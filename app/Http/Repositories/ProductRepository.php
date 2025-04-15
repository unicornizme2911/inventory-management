<?php

namespace App\Http\Repositories;

use App\Models\ProductModel;

class ProductRepository
{
    public function show($id)
    {
        $product = ProductModel::with(['category','warehouses'])->find($id);
        if(!$product){
            return null;
        }
        return $product;
    }

    public function search($name)
    {
        $product = ProductModel::with(['category','warehouses'])->where('name', 'LIKE', "%$name%")->get();
        if(!$product){
            return null;
        }
        return $product;
    }

    public function store($data)
    {
        $product = new ProductModel();
        $product->name = $data['name'];
        $product->image = $data['image'];
        $product->import_price = $data['import_price'];
        $product->retail_price = $data['retail_price'];
        $product->description = $data['description'];
        $product->category_id = $data['category_id'];
        $product->save();
        return $product;
    }
    public function update($id, $data)
    {
        $product = ProductModel::findOrFail($id);
        $product->update($data);
        return $product;
    }
}
