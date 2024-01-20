<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' =>$this->id,
            'uuid' =>$this->uuid,
            'name' =>$this->name,
            'email' =>$this->email,
            'role' =>$this->role_id,
            'avatar' => $this->image,
            'relationships' => [
                'orderer' => $this->whenLoaded('orderer', function(){
                    return new OrdererResource($this->whenLoaded('orderer'));
                }, function(){
                    return  new OrdererResource($this->orderer);
                }),
            ],
            'type' => $this->when(auth()->check() && (auth()->user()->hasRole('restaurant') || auth()->user()->hasRole('restaurant employee')), $this->type)
        ];
    }
}
