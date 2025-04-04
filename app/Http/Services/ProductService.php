<?php

namespace App\Http\Services;

use App\Http\Repositories\ProductRepository;
use App\Http\Resources\ProductResource;
use App\Models\CategoryModel;
use App\Models\InventoryModel;
use App\Models\ProductModel;
use App\Traits\ResponseAPI;

class ProductService extends BaseService
{
    use ResponseAPI;
    private $productRepository;
    public function __construct(ProductRepository $productRepository)
    {
        parent::__construct(ProductModel::class, ProductResource::class);
        $this->productRepository = $productRepository;
    }

    public function show($id){
        $product = $this->productRepository->show($id);
        return new ProductResource($product);
    }

    public function search($name){
        $product = $this->productRepository->search($name);
        return ProductResource::collection($product);
    }

    public function store($request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'import_price' => 'required|numeric',
            'retail_price' => 'required|numeric',
            'category_id' => 'required',
            'warehouse_id' => 'required',
        ]);
        $category = CategoryModel::findorFail($request->category_id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = resource_path('uploads/products');
            if(!is_dir($destinationPath)){
                mkdir($destinationPath, 0777, true);
            }
            $image->move($destinationPath, $name);
            $request->image = $name;
        }

        $product = new ProductModel();
        $product->image = $request->image;
        $product->name = $request->name;
        $product->import_price = $request->import_price;
        $product->retail_price = $request->retail_price;
        $product->description = $request->description;
        $product->category_id = $request->category_id;

        if($product->save()){
            $request->merge(['product_id' => $product->id]);
            $inventory = new InventoryService();
            $inventory->store($request);
        }
        return new ProductResource($product);
    }
}
