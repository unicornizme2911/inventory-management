<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryModel extends Model
{
    use HasFactory;

    protected $table = 'categories';
    public function products()
    {
        return $this->hasMany(ProductModel::class, 'category_id', 'id');
    }
}
