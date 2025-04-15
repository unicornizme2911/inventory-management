<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'location' => $this->location,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'products' => $this->products->map(function($product){
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'import_price' => $product->import_price,
                    'retail_price' => $product->retail_price,
                    'category' => $product->category->name,
                    'quantity' => $product->pivot->quantity,
                ];
            })->toArray(),
        ];
    }
}
