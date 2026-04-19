<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdoptionRequestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'animal_id' => $this->animal_id,
            'animal' => AnimalResource::make($this->whenLoaded('animal')),
            'adopter_id' => $this->adopter_id,
            'adopter' => UserResource::make($this->whenLoaded('adopter')),
            'status' => $this->status,
            'request_message' => $this->request_message,
            'rejection_reason' => $this->rejection_reason,
            'request_date' => $this->request_date?->toIso8601String(),
            'decision_date' => $this->decision_date?->toIso8601String(),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
