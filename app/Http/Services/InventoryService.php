<?php

namespace App\Http\Services;

use App\Http\Resources\InventoryResource;
use App\Models\InventoryModel;
use App\Models\ProductModel;
use App\Models\WarehouseModel;
use App\Traits\ResponseAPI;

class InventoryService extends BaseService
{
    use ResponseAPI;
    public function __construct(){
        parent::__construct(InventoryModel::class, InventoryResource::class);
    }
    public function store($request){
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|numeric',
            'warehouse_id' => 'required',
        ]);
        if(!ProductModel::findorFail($request->product_id) || !WarehouseModel::findorFail($request->warehouse_id)){
            return null;
        }
        $inventory = new InventoryModel();
        $inventory->product_id = $request->product_id;
        $inventory->quantity = $request->quantity;
        $inventory->warehouse_id = $request->warehouse_id;
        $inventory->save();
        return new InventoryResource($inventory);
    }
}
