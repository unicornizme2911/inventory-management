<?php

namespace App\Http\Services;

use App\Http\Repositories\EmployeeRepository;
use App\Http\Resources\EmployeeResource;
use App\Traits\ResponseAPI;
use App\Models\User;

class EmployeeService extends BaseService
{
    use ResponseAPI;
    private $employeeRepository;
    public function __construct(EmployeeRepository $employeeRepository)
    {
        parent::__construct(User::class, EmployeeResource::class);
        $this->employeeRepository = $employeeRepository;
    }

    public function getEmployees()
    {
        $user = auth()->user();
//        Show all employee
        if(!$user->isAdmin())
        {
            $employees = $this->employeeRepository->getEmployees();
        } else {
            $employees = $this->getAll();
        }
        return EmployeeResource::collection($employees);
    }

    public function show($id)
    {
        $employee = $this->employeeRepository->show($id);
        return new EmployeeResource($employee);
    }
}
