<?php

namespace App\Http\Services;

use App\Http\Resources\WarehouseResource;
use App\Models\WarehouseModel;
use App\Traits\ResponseAPI;

class WarehouseService extends BaseService
{
    use ResponseAPI;
    private $warehouseRepository;
    public function __construct()
    {
        parent::__construct(WarehouseModel::class, WarehouseResource::class);
    }
    public function show($id)
    {
        $warehouse = $this->warehouseRepository->show($id);
        if (!$warehouse) {
            return $this->error('Warehouse not found', 404);
        }
        return new WarehouseResource($warehouse);
    }
    public function store($request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);
        $warehouse = $this->warehouseRepository->store([
            'name' => $request->name,
            'location' => $request->location,
        ]);
        return new WarehouseResource($warehouse);
    }
    public function update($request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);
        $warehouse = WarehouseModel::findorFail($id);
        $warehouse->name = $request->name;
        $warehouse->location = $request->location;
        $warehouse->save();
        return new WarehouseResource($warehouse);
    }
}
