<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    use HasFactory;
    protected $table = 'orders';
    function customer(){
        return $this->belongsTo(CustomerModel::class, 'customer_id', 'id');
    }
    function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    function products(){
        return $this->belongsToMany(ProductModel::class, 'order_details', 'order_id', 'product_id')
            ->withPivot('quantity', 'price');
    }
}
