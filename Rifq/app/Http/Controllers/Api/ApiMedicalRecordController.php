<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MedicalRecordResource;
use App\Models\Animal;
use App\Models\MedicalRecord;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiMedicalRecordController extends Controller
{
    public function index(Request $request, string $animalUuid): JsonResponse
    {
        $animal = Animal::where('uuid', $animalUuid)->firstOrFail();

        $records = $animal->medicalRecords()
            ->with('vet')
            ->orderBy('visit_date', 'desc')
            ->paginate($request->input('per_page', 15));

        return response()->json(MedicalRecordResource::collection($records)->response()->getData(true));
    }

    public function store(Request $request, string $animalUuid): JsonResponse
    {
        $animal = Animal::where('uuid', $animalUuid)->firstOrFail();

        $validated = $request->validate([
            'record_type' => 'required|string|max:255',
            'diagnosis' => 'nullable|string',
            'treatment_given' => 'nullable|string',
            'visit_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $record = $animal->medicalRecords()->create([
            ...$validated,
            'vet_id' => $request->user()->id,
        ]);

        return response()->json(new MedicalRecordResource($record->load('vet')), 201);
    }

    public function show(string $animalUuid, MedicalRecord $medicalRecord): JsonResponse
    {
        $animal = Animal::where('uuid', $animalUuid)->firstOrFail();

        if ($medicalRecord->animal_id !== $animal->id) {
            return response()->json(['message' => __('messages.access_denied')], 403);
        }

        return response()->json(new MedicalRecordResource($medicalRecord->load('vet')));
    }

    public function update(Request $request, string $animalUuid, MedicalRecord $medicalRecord): JsonResponse
    {
        $animal = Animal::where('uuid', $animalUuid)->firstOrFail();

        if ($medicalRecord->animal_id !== $animal->id) {
            return response()->json(['message' => __('messages.access_denied')], 403);
        }

        $validated = $request->validate([
            'record_type' => 'sometimes|string|max:255',
            'diagnosis' => 'nullable|string',
            'treatment_given' => 'nullable|string',
            'visit_date' => 'sometimes|date',
            'notes' => 'nullable|string',
        ]);

        $medicalRecord->update($validated);

        return response()->json(new MedicalRecordResource($medicalRecord->load('vet')));
    }

    public function destroy(string $animalUuid, MedicalRecord $medicalRecord): JsonResponse
    {
        $animal = Animal::where('uuid', $animalUuid)->firstOrFail();

        if ($medicalRecord->animal_id !== $animal->id) {
            return response()->json(['message' => __('messages.access_denied')], 403);
        }

        $medicalRecord->delete();

        return response()->json(['message' => __('messages.record_deleted_successfully')]);
    }
}
