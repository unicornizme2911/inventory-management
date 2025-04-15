<?php

namespace App\Http\Services;

use App\Http\Repositories\CustomerRepository;
use App\Http\Resources\CustomerResource;
use App\Models\CustomerModel;
use App\Traits\ResponseAPI;

class CustomerService extends BaseService
{
    use ResponseAPI;
    private $customerRepository;
    public function __construct(CustomerRepository $customerRepository)
    {
        parent::__construct(CustomerModel::class, CustomerResource::class);
        $this->customerRepository = $customerRepository;
    }

    public function show($id)
    {
        $category = $this->customerRepository->show($id);
        if (!$category)
        {
            return null;
        }
        return new CustomerResource($category);
    }

    public function search($phone)
    {
        $category = $this->customerRepository->search($phone);
        if (!$category)
        {
            return null;
        }
        return CustomerResource::collection($category);
    }

    public function store($request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|email',
            'phone' => 'required|string'
        ]);
        $customerData = [
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'loyal_points' => 0 || $request->loyal_points
        ];
        $customer = $this->customerRepository->store($customerData);
        return new CustomerResource($customer);
    }

    public function update($request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $category = CustomerModel::findorFail($id);
        $category->name = $request->name;
        $category->save();
        return new CustomerResource($category);
    }

    public function destroy($id)
    {
        $category = CustomerModel::findorFail($id);
        if (!$category)
        {
            return null;
        }
        $category->delete();
        return new CustomerResource($category);
    }
}
