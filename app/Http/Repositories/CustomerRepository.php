<?php

namespace App\Http\Repositories;
use App\Models\CustomerModel;
class CustomerRepository
{
    public function show($id){
        $customer = CustomerModel::find($id);
        if(!$customer){
            return null;
        }
        return $customer;
    }

    public function search($phone)
    {
        $customer = CustomerModel::where('phone', $phone)->get();
        if (!$customer) {
            return null;
        }
        return $customer;
    }

    public function store($data)
    {
        $customer = new CustomerModel();
        $customer->name = $data['name'];
        $customer->address = $data['address'];
        $customer->phone = $data['phone'];
        $customer->loyal_points = $data['loyal_points'];
        $customer->save();
        return $customer;
    }
}
