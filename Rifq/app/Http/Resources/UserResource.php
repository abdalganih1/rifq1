<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'username' => $this->username,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'gender' => $this->gender,
            'specialization' => $this->specialization,
            'academic_level' => $this->academic_level,
            'governorate_id' => $this->governorate_id,
            'governorate' => GovernorateResource::make($this->whenLoaded('governorate')),
            'organization_id' => $this->organization_id,
            'organization' => OrganizationResource::make($this->whenLoaded('organization')),
            'independent_team_id' => $this->independent_team_id,
            'independent_team' => IndependentTeamResource::make($this->whenLoaded('independentTeam')),
            'roles' => $this->whenLoaded('roles', fn() => $this->roles->pluck('name')),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
