<?php

namespace App\Http\Repositories;
use App\Models\User;

class EmployeeRepository
{
    public function getEmployees(){
        $user = User::where('user_type', 0)->get();
        if(!$user){
            return null;
        }
        return $user;
    }

    public function show($id)
    {
        $user = User::find($id);
        if(!$user){
            return null;
        }
        return $user;
    }
}
