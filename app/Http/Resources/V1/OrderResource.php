<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
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
                'deliveryLat' => $this->delivery_location_lat,
                'deliveryLng' => $this->delivery_location_lng,
                'createdAt' => $this->created_at->format('D, M j, Y g:i A'),
                'status' => (string) $this->status,
                'paymentStatus' => $this->payment && $this->payment->status == 2 ? 'Paid' : 'Pending',
                'service_charge' => $this->service_charge,
                'booking_time' => $this->booking_time ? Carbon::parse($this->booking_time)->format('D, M j, Y g:i A') : NULL,
                'discount' => $this->discount,
                'preparation_time' => $this->getTotalPreparationTime(),
                'restaurant_name' => $this->restaurant->name,
                'user_name' => $this->user->name,
            ],
            'relationships' => [
                'user' => new UserResource($this->whenLoaded('user')),
                'restaurant' => new RestaurantResource($this->whenLoaded('restaurant')),
                'orderItems' => OrderItemResource::collection($this->whenLoaded('orderItems')),
                'reservation' => $this->whenLoaded('reservation'),
                'orphanage' => new OrphanageResource($this->whenLoaded('orphanage')),
            ]
        ];
    }
}
