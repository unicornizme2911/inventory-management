<?php

namespace App\Http\Controllers;

use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use App\Http\Services\CustomerService;

class CustomerController extends Controller
{
    use ResponseAPI;
    private $customerService;
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }
    public function index()
    {
        return view('customer.list');
    }

    public function getAll()
    {
        $customers = $this->customerService->getAll();
        return $customers ? $this->success('Customers retrieved successfully', $customers) : $this->error('Customers not found', 404);
    }

    public function show(Request $request, $id)
    {
        $customer = $this->customerService->show($id);
        return $customer ? $this->success('Customer retrieved successfully', $customer) : $this->error('Customer not found', 404);
    }

    public function search($phone)
    {
        $customer = $this->customerService->search($phone);
        return $customer ? $this->success('Customer retrieved successfully', $customer) : $this->error('Customer not found', 404);
    }

    public function store(Request $request)
    {
        $customer = $this->customerService->store($request);
        return $customer ? $this->success('Customer created successfully', $customer) : $this->error('Create customer failed', 500);
    }
}
