<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdoptionRequestResource;
use App\Http\Resources\AnimalResource;
use App\Models\AdoptionRequest;
use App\Models\Animal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiAdoptionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Animal::with(['organization', 'independentTeam.governorate'])
            ->where('status', 'available_for_adoption');

        if ($request->filled('species')) {
            $query->where('species', $request->input('species'));
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        $perPage = min($request->input('per_page', 12), 100);
        $animals = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json(AnimalResource::collection($animals)->response()->getData(true));
    }

    public function show(Animal $animal): JsonResponse
    {
        $animal->load(['organization', 'independentTeam.governorate', 'medicalRecords' => fn($q) => $q->orderBy('visit_date', 'desc')->limit(5)]);

        return response()->json(new AnimalResource($animal));
    }

    public function submitRequest(Request $request, Animal $animal): JsonResponse
    {
        $request->validate([
            'request_message' => 'required|string|max:1000',
        ]);

        $existingRequest = AdoptionRequest::where('animal_id', $animal->id)
            ->where('adopter_id', $request->user()->id)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingRequest) {
            return response()->json([
                'message' => 'لديك طلب قيد المعالجة بالفعل لهذا الحيوان.',
                'existing_request' => new AdoptionRequestResource($existingRequest),
            ], 409);
        }

        $adoptionRequest = AdoptionRequest::create([
            'animal_id' => $animal->id,
            'adopter_id' => $request->user()->id,
            'status' => 'pending',
            'request_message' => $request->request_message,
            'request_date' => now(),
        ]);

        return response()->json(new AdoptionRequestResource($adoptionRequest->load(['animal', 'adopter'])), 201);
    }

    public function myRequests(Request $request): JsonResponse
    {
        $requests = AdoptionRequest::with(['animal.organization', 'animal.independentTeam'])
            ->where('adopter_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate($request->input('per_page', 10));

        return response()->json(AdoptionRequestResource::collection($requests)->response()->getData(true));
    }

    public function cancelRequest(Request $request, AdoptionRequest $adoptionRequest): JsonResponse
    {
        if ($adoptionRequest->adopter_id !== $request->user()->id) {
            return response()->json(['message' => __('messages.access_denied')], 403);
        }

        if ($adoptionRequest->status !== 'pending') {
            return response()->json(['message' => 'لا يمكن إلغاء هذا الطلب.'], 400);
        }

        $adoptionRequest->update([
            'status' => 'cancelled',
            'decision_date' => now(),
        ]);

        return response()->json(new AdoptionRequestResource($adoptionRequest->load(['animal', 'adopter'])));
    }
}
