<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "name" => $this->name,
            "surname" => $this->surname,
            "company" => $this->company,
            "vat" => $this->vat,
            "region" => $this->region,
            "city" => $this->city,
            "address" => $this->address,
            "cp" => $this->cp,
            "phone" => $this->phone,
            "email" => $this->email,
            "created_at" => $this->created_at->toDateTimeString(),
            "updated_at" => $this->updated_at->toDateTimeString(),
        ];
    }
}
