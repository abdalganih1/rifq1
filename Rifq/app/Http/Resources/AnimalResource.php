<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnimalResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'serial_number' => $this->serial_number,
            'data_entered_status' => $this->data_entered_status,
            'name' => $this->name,
            'species' => $this->species,
            'animal_type' => $this->animal_type,
            'animal_type_en' => $this->animal_type_en,
            'custom_animal_type' => $this->custom_animal_type,
            'breed' => $this->breed,
            'breed_name' => $this->breed_name,
            'breed_name_en' => $this->breed_name_en,
            'gender' => $this->gender,
            'estimated_age' => $this->estimated_age,
            'color' => $this->color,
            'color_en' => $this->color_en,
            'distinguishing_marks' => $this->distinguishing_marks,
            'distinguishing_marks_en' => $this->distinguishing_marks_en,
            'status' => $this->status,
            'location_found' => $this->location_found,
            'city_province' => $this->city_province,
            'city_province_en' => $this->city_province_en,
            'relocation_place' => $this->relocation_place,
            'relocation_place_en' => $this->relocation_place_en,
            'image_url' => $this->image_url,
            'medical_procedures' => $this->medical_procedures,
            'parasite_treatments' => $this->parasite_treatments,
            'vaccinations_details' => $this->vaccinations_details,
            'medical_supervisor_info' => $this->medical_supervisor_info,
            'emergency_contact_phone' => $this->emergency_contact_phone,
            'organization_id' => $this->organization_id,
            'organization' => OrganizationResource::make($this->whenLoaded('organization')),
            'owner_id' => $this->owner_id,
            'owner' => UserResource::make($this->whenLoaded('owner')),
            'independent_team_id' => $this->independent_team_id,
            'independent_team' => IndependentTeamResource::make($this->whenLoaded('independentTeam')),
            'creator' => UserResource::make($this->whenLoaded('creator')),
            'medical_records' => MedicalRecordResource::collection($this->whenLoaded('medicalRecords')),
            'adoption_requests' => AdoptionRequestResource::collection($this->whenLoaded('adoptionRequests')),
            'ai_scans' => AIScanResource::collection($this->whenLoaded('aiScans')),
            'qr_code_links' => AnimalQrLinkResource::collection($this->whenLoaded('qrCodeLinks')),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
