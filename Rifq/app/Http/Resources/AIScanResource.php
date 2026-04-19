<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AIScanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'animal_id' => $this->animal_id,
            'animal' => AnimalResource::make($this->whenLoaded('animal')),
            'user_id' => $this->user_id,
            'user' => UserResource::make($this->whenLoaded('user')),
            'scan_type' => $this->scan_type,
            'media_url' => $this->media_url,
            'ai_prediction' => $this->ai_prediction,
            'confidence_score' => $this->confidence_score,
            'scan_date' => $this->scan_date?->toIso8601String(),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
