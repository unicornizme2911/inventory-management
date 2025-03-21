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
        'description',
        'category_id',
    ];
    public function category(){
        return $this->belongsTo(CategoryModel::class, 'category_id');
    }
    public function warehouses(){
        return $this->belongsToMany(WarehouseModel::class, 'inventories', 'product_id', 'warehouse_id')->withPivot('quantity');
    }
}
