<?php

namespace App\Http\Resources\V1;

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
            'id' =>$this->id,
            'uuid' => $this->uuid,
            'attributes' => [
                'userId' => $this->user_id,
                'totalAmount' => $this->total_amount,
                'delivery' => $this->delivery,
                'deliveryFee' => $this->delivery_fee,
                'deliveryAddress' => $this->delivery_address,
                'deliveryStatus' => $this->delivery_status,
                'status' => (string) $this->status,
            ],
            'relationships' => [
                'user' => new UserResource($this->whenLoaded('user')),
                'restaurant' => new RestaurantResource($this->whenLoaded('restaurant')),
                'orderItems' => OrderItemResource::collection($this->whenLoaded('orderItems')),
            ]
                        
        ];
    }
}