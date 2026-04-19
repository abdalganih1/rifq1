<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndependentTeamResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'governorate_id' => $this->governorate_id,
            'governorate' => GovernorateResource::make($this->whenLoaded('governorate')),
            'contact_phone' => $this->contact_phone,
            'prefix' => $this->prefix,
        ];
    }
}
