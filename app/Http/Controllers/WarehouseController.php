<?php

namespace App\Http\Controllers;

use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use App\Http\Services\WarehouseService;
class WarehouseController extends Controller
{
    use ResponseAPI;
    private $warehouseService;
    public function __construct(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
    }

    public function index()
    {
        return view('warehouse.list');
    }

    public function getAll()
    {
        $warehouses = $this->warehouseService->getAll();
        return $warehouses ? $this->success('Warehouses retrieved successfully', $warehouses) : $this->error('Warehouses not found', 404);
    }

    public function store(Request $request)
    {
        $warehouse = $this->warehouseService->store($request);
        return $warehouse ? $this->success('Warehouse created successfully', $warehouse) : $this->error('Warehouse not created', 500);
    }

    public function show($id)
    {
        $warehouse = $this->warehouseService->show($id);
        return $warehouse ? $this->success('Warehouse retrieved successfully', $warehouse) : $this->error('Warehouse not found', 404);
    }

    public function update(Request $request, $id)
    {
        $warehouse = $this->warehouseService->update($request, $id);
        return $warehouse ? $this->success('Warehouse updated successfully', $warehouse) : $this->error('Warehouse not updated', 500);
    }
}
