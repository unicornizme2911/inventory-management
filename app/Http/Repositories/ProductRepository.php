<?php

namespace App\Http\Repositories;

use App\Models\ProductModel;

class ProductRepository
{
    public function show($id){
        $product = ProductModel::with(['category','warehouses'])->find($id);
        if(!$product){
            return null;
        }
        return $product;
    }

    public function search($name){
        $product = ProductModel::with(['category','warehouses'])->where('name', $name)->get();
        if(!$product){
            return null;
        }
        return $product;
    }
}
