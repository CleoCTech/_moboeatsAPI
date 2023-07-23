<?php

namespace App\Http\Resources\V1;

use App\Models\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
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
            'attributes' => [
                'name' =>$this->name,
                'nameShort' =>$this->name_short,
                'email' =>$this->email,
                'about' =>$this->about,
                'aboutShort' =>$this->about_short,
                'phoneNo' =>$this->phone_no,
                'address' =>$this->address,
                'city' =>$this->city,
                'state' =>$this->state,
                'postalCode' =>$this->postal_code,
                'latitude' =>$this->latitude,
                'longitude' =>$this->longitude,
                'mapLocation' =>$this->map_location,
                'url' =>$this->url,
                'logo' =>$this->logo,
                'status' => (string) $this->status, 
            ],
            'relationships' => [
                'questionnaire' => new QuestionnaireResource($this->whenLoaded('questionnaire')),
                'user' => new UserResource($this->whenLoaded('user')),
            ]
            // 'questionnaire' => QuestionnaireResource::collection($this->whenLoaded('questionnaire')),
           
        ];
    }
}
