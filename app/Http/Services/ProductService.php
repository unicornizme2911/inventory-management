<?php

namespace App\Http\Services;

use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\InventoryRepository;
use App\Models\ProductModel;
use App\Http\Resources\ProductResource;
use App\Traits\ResponseAPI;

class ProductService extends BaseService
{
    use ResponseAPI;
    private $productRepository;
    private $categoryRepository;
    private $inventoryRepository;
    public function __construct(ProductRepository $productRepository,
                                CategoryRepository $categoryRepository,
                                InventoryRepository $inventoryRepository)
    {
        parent::__construct(ProductModel::class, ProductResource::class);
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->inventoryRepository = $inventoryRepository;
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
            'quantity' => 'required|numeric',
        ]);
        $category = $this->categoryRepository->show($request->category_id);
        if(!$category)
        {
            return $this->error('Category not found', 404);
        }

        $image = $this->handleImageUpload($request);

        $productData = [
            'name' => $request->name,
            'import_price' => $request->import_price,
            'retail_price' => $request->retail_price,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'image' => $image,
        ];

        $product = $this->productRepository->store($productData);
        if($product)
        {
            $inventoryData = [
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'warehouse_id' => $request->warehouse_id,
            ];
            $this->inventoryRepository->store($inventoryData);
        }

        return new ProductResource($product);
    }

    public function handleImageUpload($request)
    {
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/products');
            if(!is_dir($destinationPath))
            {
                mkdir($destinationPath, 0777, true);
            }
            $image->move($destinationPath, $name);
            return $name;
        }
        return null;
    }

    public function update($request, $id)
    {
        $product = $this->productRepository->show($id);
        if(!$product)
        {
            return $this->error('Product not found', 404);
        }
        if($request->filled('quantity'))
        {
            $inventoryData = [
                'product_id' => $id,
                'quantity' => $request->quantity,
                'warehouse_id' => $request->warehouse_id,
            ];
            $this->inventoryRepository->update($inventoryData);
        }
        $productData = $request->only(['name', 'import_price', 'retail_price', 'description', 'category_id']);
        if($request->hasFile('image'))
        {
            $image = $this->handleImageUpload($request);
            $productData['image'] = $image;
        }

        $updatedProduct = $this->productRepository->update($id, $productData);
        return new ProductResource($updatedProduct);
    }
}
