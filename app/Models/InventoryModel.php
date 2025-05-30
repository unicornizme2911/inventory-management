<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryModel extends Model
{
    use HasFactory;

    protected $table = 'inventories';
    protected $fillable = [
        'product_id',
        'warehouse_id',
        'quantity'
    ];
}
