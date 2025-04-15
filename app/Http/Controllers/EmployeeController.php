<?php

namespace App\Http\Controllers;

use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use App\Http\Services\EmployeeService;

class EmployeeController extends Controller
{
    use ResponseAPI;
    private $employeeService;
    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }
    public function index()
    {
        return view('employee.list');
    }

    public function getAll()
    {
        $employees = $this->employeeService->getEmployees();
        return $employees ? $this->success('Employees retrieved successfully', $employees) : $this->error('Employees not found', 404);
    }

    public function show($id)
    {
        $employee = $this->employeeService->show($id);
        $totalIncome = $employee->orders->sum('total_amount');
        return view('employee.detail', compact('employee', 'totalIncome'));
    }
}
