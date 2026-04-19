<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnimalResource;
use App\Models\Animal;
use App\Models\AnimalQrLink;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ApiAnimalController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Animal::with(['independentTeam.governorate', 'organization', 'creator']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('serial_number', 'like', "%{$search}%")
                    ->orWhere('animal_type', 'like', "%{$search}%")
                    ->orWhere('breed_name', 'like', "%{$search}%")
                    ->orWhere('uuid', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('species')) {
            $query->where('species', $request->input('species'));
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        if ($request->filled('data_entered')) {
            $query->where('data_entered_status', filter_var($request->input('data_entered'), FILTER_VALIDATE_BOOLEAN));
        }

        if ($request->filled('organization_id')) {
            $query->where('organization_id', $request->input('organization_id'));
        }

        if ($request->filled('independent_team_id')) {
            $query->where('independent_team_id', $request->input('independent_team_id'));
        }

        $perPage = min($request->input('per_page', 15), 100);
        $animals = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json(AnimalResource::collection($animals)->response()->getData(true));
    }

    public function show(string $uuid): JsonResponse
    {
        $animal = Animal::where('uuid', $uuid)
            ->with(['independentTeam.governorate', 'organization', 'creator', 'medicalRecords.vet', 'adoptionRequests', 'aiScans', 'qrCodeLinks'])
            ->firstOrFail();

        return response()->json(new AnimalResource($animal));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'animal_type' => 'required|string|max:255',
            'animal_type_en' => 'nullable|string|max:255',
            'custom_animal_type' => 'nullable|string|max:255',
            'breed_name' => 'nullable|string|max:255',
            'breed_name_en' => 'nullable|string|max:255',
            'gender' => 'required|in:Male,Female,Unknown',
            'estimated_age' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'color_en' => 'nullable|string|max:255',
            'distinguishing_marks' => 'nullable|string',
            'distinguishing_marks_en' => 'nullable|string',
            'city_province' => 'nullable|string|max:255',
            'city_province_en' => 'nullable|string|max:255',
            'relocation_place' => 'nullable|string|max:255',
            'relocation_place_en' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:255',
            'independent_team_id' => 'nullable|exists:independent_teams,id',
            'organization_id' => 'nullable|exists:organizations,id',
            'image' => 'nullable|image|max:5120',
            'medical_procedures' => 'nullable|array',
            'parasite_treatments' => 'nullable|array',
            'vaccinations_details' => 'nullable|array',
            'medical_supervisor_info' => 'nullable|array',
        ]);

        $animal = new Animal();
        $animal->uuid = Str::uuid()->toString();
        $animal->qr_code_hash = Str::uuid()->toString();
        $animal->created_by = $request->user()->id;
        $animal->last_updated_by = $request->user()->id;
        $animal->data_entered_status = true;

        $animal->fill(collect($validated)->except(['image'])->toArray());

        if (!$animal->independent_team_id && $request->user()->independent_team_id) {
            $animal->independent_team_id = $request->user()->independent_team_id;
        }

        if ($request->hasFile('image')) {
            $animal->image_path = $request->file('image')->store('animals', 'public');
        }

        $animal->save();
        $animal->generateSerialNumber();

        return response()->json(new AnimalResource($animal->load(['independentTeam.governorate', 'creator'])), 201);
    }

    public function update(Request $request, string $uuid): JsonResponse
    {
        $animal = Animal::where('uuid', $uuid)->firstOrFail();

        $validated = $request->validate([
            'animal_type' => 'sometimes|string|max:255',
            'animal_type_en' => 'nullable|string|max:255',
            'custom_animal_type' => 'nullable|string|max:255',
            'breed_name' => 'nullable|string|max:255',
            'breed_name_en' => 'nullable|string|max:255',
            'gender' => 'sometimes|in:Male,Female,Unknown',
            'estimated_age' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'color_en' => 'nullable|string|max:255',
            'distinguishing_marks' => 'nullable|string',
            'distinguishing_marks_en' => 'nullable|string',
            'status' => 'nullable|string|max:255',
            'city_province' => 'nullable|string|max:255',
            'city_province_en' => 'nullable|string|max:255',
            'relocation_place' => 'nullable|string|max:255',
            'relocation_place_en' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:255',
            'independent_team_id' => 'nullable|exists:independent_teams,id',
            'image' => 'nullable|image|max:5120',
            'medical_procedures' => 'nullable|array',
            'parasite_treatments' => 'nullable|array',
            'vaccinations_details' => 'nullable|array',
            'medical_supervisor_info' => 'nullable|array',
        ]);

        $animal->fill(collect($validated)->except(['image'])->toArray());
        $animal->last_updated_by = $request->user()->id;

        if ($request->hasFile('image')) {
            if ($animal->image_path) {
                Storage::disk('public')->delete($animal->image_path);
            }
            $animal->image_path = $request->file('image')->store('animals', 'public');
        }

        $animal->save();

        return response()->json(new AnimalResource($animal->load(['independentTeam.governorate', 'creator'])));
    }

    public function destroy(Request $request, string $uuid): JsonResponse
    {
        $animal = Animal::where('uuid', $uuid)->firstOrFail();
        $animal->delete();

        return response()->json(['message' => __('messages.animal_deleted_successfully')]);
    }

    public function publicShow(string $uuid): JsonResponse
    {
        $animal = Animal::where('uuid', $uuid)
            ->with(['independentTeam.governorate', 'medicalRecords' => fn($q) => $q->orderBy('visit_date', 'desc')->limit(5)])
            ->first();

        if (!$animal) {
            return response()->json(['message' => __('messages.animal_not_found')], 404);
        }

        return response()->json(new AnimalResource($animal));
    }

    public function scanByHash(string $hash): JsonResponse
    {
        $animal = Animal::where('qr_code_hash', $hash)
            ->with(['independentTeam.governorate', 'medicalRecords' => fn($q) => $q->orderBy('visit_date', 'desc')->limit(5)])
            ->first();

        if (!$animal) {
            $animal = Animal::where('uuid', $hash)->first();
        }

        if (!$animal) {
            return response()->json(['message' => __('messages.animal_not_found')], 404);
        }

        return response()->json(new AnimalResource($animal));
    }
}
