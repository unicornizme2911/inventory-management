<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'image' => $this->image,
            'import_price' => $this->import_price,
            'retail_price' => $this->retail_price,
            'description' => $this->description,
            'category' => $this->category,
            'warehouses' => $this->warehouses->map(function($warehouse){
                return [
                    'id' => $warehouse->id,
                    'name' => $warehouse->name,
                    'quantity' => $warehouse->pivot->quantity,
                ];
            })->toArray(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
