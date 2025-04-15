<?php

namespace App\Http\Services;

use App\Http\Repositories\InventoryRepository;
use App\Http\Resources\InventoryResource;
use App\Models\InventoryModel;
use App\Models\ProductModel;
use App\Models\WarehouseModel;
use App\Traits\ResponseAPI;

class InventoryService extends BaseService
{
    use ResponseAPI;
    private $inventoryRepository;
    public function __construct(InventoryRepository $inventoryRepository){
        parent::__construct(InventoryModel::class, InventoryResource::class);
        $this->inventoryRepository = $inventoryRepository;
    }
    public function store($request){
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|numeric',
            'warehouse_id' => 'required',
        ]);
        if(!ProductModel::find($request->product_id) || !WarehouseModel::find($request->warehouse_id)){
            return null;
        }
        $inventory = $this->inventoryRepository->store($request);
        return new InventoryResource($inventory);
    }
}
