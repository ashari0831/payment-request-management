<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentRequestResource extends JsonResource
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
            "status" => $this->status,
            "file_id" => $this->file_id,
            "payment_category" => $this->paymentCategory,
            "description" => $this->description,
            "price" => $this->price,
            "sheba_number" => $this->sheba_number,
            "user" => $this->user,
            "comments" => $this->comments,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
