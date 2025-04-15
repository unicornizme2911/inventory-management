<?php

namespace App\Http\Repositories;

use App\Models\OrderModel;
class OrderRepository
{
    public function show($orderId)
    {
        // Assuming you have an Order model and you want to fetch the order by ID
        $order = OrderModel::find($orderId);
        if (!$order) {
            return null; // or throw an exception
        }
        return $order;
    }
    public function store($data)
    {
        // Assuming you have an Order model and you want to create a new order
        $order = new OrderModel();
        $order->customer_id = $data['customer_id'];
        $order->user_id = $data['user_id'];
        $order->warehouse_id = $data['warehouse_id'];
        $order->total_amount = $data['total_amount'];
        $order->status = $data['status'];
        $order->save();
        return $order;
    }
}
