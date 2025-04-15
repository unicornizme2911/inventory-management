<?php

namespace App\Http\Repositories;
use App\Models\InventoryModel;
class InventoryRepository
{
    public function show($id){
        $category = InventoryModel::find($id);
        if(!$category){
            return null;
        }
        return $category;
    }
    public function store($data){
        $inventory = new InventoryModel();
        $inventory->product_id = $data['product_id'];
        $inventory->warehouse_id = $data['warehouse_id'];
        $inventory->quantity = $data['quantity'];
        $inventory->save();
        return $inventory;
    }
    public function update($data){
        $inventory = InventoryModel::where('product_id', $data['product_id'])
                                    ->where('warehouse_id', $data['warehouse_id'])
                                    ->first();
        if(!$inventory){
            return null;
        }
        $inventory->update($data);
        return $inventory;
    }
}
