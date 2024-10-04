<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "user_id"=>$this->user_id,
            "total"=>$this->total,
            "products"=>$this->products->map(function($product){
                return [
                    "id"=>$product->id,
                    "name"=>$product->name,
                    "quantity"=>$product->pivot->quantity,
                    "price"=>$product->pivot->price,
                    "image_url"=>$product->image_url

                ];
            })
        ];
    }
}
