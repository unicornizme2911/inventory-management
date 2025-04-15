<?php

namespace App\Models;

use App\Traits\ResponseAPI;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetailModel extends Model
{
    use hasFactory;
    protected $table = 'order_details';
}
