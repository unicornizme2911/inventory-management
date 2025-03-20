<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'image',
        'name',
        'import_price',
        'retail_price',
        'quantity',
        'description',
        'category_id',
    ];
}
