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
            // 'id' =>(string)$this->id,
            'uuid' =>$this->uuid,
            'name' =>$this->name,
            'email' =>$this->email,
            // 'status' =>$this->status,
        ];
    }
}
