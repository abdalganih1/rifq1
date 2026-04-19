<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicalRecordResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'animal_id' => $this->animal_id,
            'vet_id' => $this->vet_id,
            'vet' => UserResource::make($this->whenLoaded('vet')),
            'record_type' => $this->record_type,
            'diagnosis' => $this->diagnosis,
            'treatment_given' => $this->treatment_given,
            'visit_date' => $this->visit_date?->toIso8601String(),
            'notes' => $this->notes,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
