<?php

namespace App\Http\Repositories;
use App\Models\CategoryModel;
class CategoryRepository
{
    public function show($id){
        $category = CategoryModel::find($id);
        if(!$category){
            return null;
        }
        return $category;
    }
}
