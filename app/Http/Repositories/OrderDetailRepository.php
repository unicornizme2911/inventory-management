<?php

namespace App\Http\Repositories;

use App\Models\OrderDetailModel;

class OrderDetailRepository
{

    public function store($data)
    {
        $orderDetail = new OrderDetailModel();
        $orderDetail->order_id = $data['order_id'];
        $orderDetail->product_id = $data['product_id'];
        $orderDetail->quantity = $data['quantity'];
        $orderDetail->unit_price = $data['unit_price'];
        $orderDetail->total_price = $data['total_price'];
        $orderDetail->save();
        return $orderDetail;
    }
}
