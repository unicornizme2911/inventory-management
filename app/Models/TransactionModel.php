<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionModel extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    function products ()
    {
        return $this->belongsToMany(ProductModel::class, 'transaction_details', 'transaction_id', 'product_id')
            ->withPivot('quantity', 'total_price');
    }
}
