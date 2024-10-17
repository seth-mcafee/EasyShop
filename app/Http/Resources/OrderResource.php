<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "total" => $this->total,
            "status" => $this->status,
            "payment_status"=>$this->payments()->latest()->first()->status ?? null,
            "delivered_at"=>$this->delivered_at?$this->delivered_at:null,
            "products"=>$this->products->map(function($product){
                return [
                    "name"=>$product->name,
                    "quantity"=>$product->pivot->quantity,
                    "price"=>$product->pivot->price,
                    "image_url"=>$product->image_url

                ];
            })

        ];
    }
}
