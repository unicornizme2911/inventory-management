<?php

namespace App\Http\Services;

use App\Http\Repositories\CustomerRepository;
use App\Http\Repositories\OrderDetailRepository;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\WarehouseRepository;
use App\Http\Resources\OrderResource;
use App\Models\OrderModel;
use App\Traits\ResponseAPI;

class OrderService extends BaseService
{
    use ResponseAPI;
    private $orderRepository;
    private $warehouseRepository;
    private $customerRepository;
    private $orderDetailRepository;
    public function __construct(OrderRepository $orderRepository,
                                WarehouseRepository $warehouseRepository,
                                CustomerRepository $customerRepository,
                                OrderDetailRepository $orderDetailRepository)
    {
        parent::__construct(OrderModel::class, OrderResource::class);
        $this->orderRepository = $orderRepository;
        $this->warehouseRepository = $warehouseRepository;
        $this->customerRepository = $customerRepository;
        $this->orderDetailRepository = $orderDetailRepository;
    }
    public function show($id){
        $order = $this->orderRepository->show($id);
        return new OrderResource($order);
    }

    public function store($request)
    {
        $request->validate([
            'customer_id' => 'required',
            'user_id' => 'required',
            'warehouse_id' => 'required',
            'products' => 'required|array'
        ]);
        $customer = $this->customerRepository->show($request->customer_id);
        if(!$customer)
        {
            return $this->error('Customer not found', 404);
        }else{
            $customerData = [
                'name' => $customer->name,
                'phone' => $customer->phone,
                'address' => $customer->address,
                'loyal_points' => $customer->loyal_points ?? 0,
            ];
            $customer = $this->customerRepository->store($customerData);
        }
        $warehouse = $this->warehouseRepository->show($request->warehouse_id);
        if(!$warehouse)
        {
            return $this->error('Warehouse not found', 404);
        }else{
            $warehouseData = [
                'name' => $warehouse->name,
                'location' => $warehouse->location,
            ];
            $warehouse = $this->warehouseRepository->store($warehouseData);
        }
        $orderData = [
            'customer_id' => $customer->id,
            'user_id' => $request->user_id,
            'warehouse_id' => $warehouse->id,
            'total_amount' => 0,
            'status' => 'pending',
        ];
        $order = $this->orderRepository->store($orderData);
        $totalAmount = 0;
        foreach($request->products as $product){
            $orderDetailData = [
                'order_id' => $order->id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'unit_price' => $product['unit_price'],
                'total_price' => $product['quantity'] * $product['unit_price'],
            ];
            $this->orderDetailRepository->store($orderDetailData);
            $totalAmount += $orderDetailData['total_price'];
        }
        $order->update(['total_amount' => $totalAmount]);
        return new OrderResource($order);
    }
}
