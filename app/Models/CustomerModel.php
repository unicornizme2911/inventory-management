<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerModel extends Model
{
    use HasFactory;
    protected $table = 'customers';
    function orders()
    {
        return $this->hasMany(OrderModel::class, 'customer_id', 'id');
    }
}
