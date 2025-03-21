<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseModel extends Model
{
    use HasFactory;

    protected $table = 'warehouses';

    public function products()
    {
        return $this->belongsToMany(ProductModel::class, 'inventories', 'warehouse_id', 'product_id')
                    ->withPivot('quantity');
    }
}
