<?php

namespace App\Http\Repositories;

use App\Models\WarehouseModel;

class WarehouseRepository
{
    public function show($warehouseId)
    {
        // Assuming you have a Warehouse model and you want to fetch the warehouse by ID
        $warehouse = WarehouseModel::find($warehouseId);
        if (!$warehouse) {
            return null; // or throw an exception
        }
        return $warehouse;
    }
    public function store($data)
    {
        // Assuming you have a Warehouse model and you want to create a new warehouse
        $warehouse = new WarehouseModel();
        $warehouse->name = $data['name'];
        $warehouse->location = $data['location'];
        $warehouse->save();
        return $warehouse;
    }
}
