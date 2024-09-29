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
            "id" => $this->resource->id,
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'price' => $this->resource->price,
            'quantity' => $this->resource->quantity,
            'seller' => $this->resource->seller ? [
                "id" => $this->resource->seller->id,
                "name" => $this->resource->seller->name
            ] : null,
            'category' => $this->resource->category ? [
                "id" => $this->resource->category->id,
                "name" => $this->resource->category->name
            ] : null,
            'image_url' => url('/storage/'.$this->resource->image_url),
            'created_at' => $this->resource->created_at->format("d-m-Y h:i:s")
        ];
    }
}
