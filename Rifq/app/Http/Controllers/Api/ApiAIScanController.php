<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AIScanResource;
use App\Models\AIScan;
use App\Models\Animal;
use App\Services\AIService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiAIScanController extends Controller
{
    public function index(Request $request, string $animalUuid): JsonResponse
    {
        $animal = Animal::where('uuid', $animalUuid)->firstOrFail();

        $scans = $animal->aiScans()
            ->with(['user', 'animal'])
            ->orderBy('scan_date', 'desc')
            ->paginate($request->input('per_page', 15));

        return response()->json(AIScanResource::collection($scans)->response()->getData(true));
    }

    public function analyze(Request $request): JsonResponse
    {
        $request->validate([
            'media' => 'required|file|mimes:jpeg,png,jpg,gif,mp4,avi,mov|max:51200',
            'animal_uuid' => 'nullable|string|exists:animals,uuid',
            'scan_type' => 'nullable|string|in:health_check,behavior_analysis,breed_identification',
        ]);

        $aiService = new AIService();
        $result = $aiService->analyzeMedia($request->file('media'), $request->input('scan_type'));

        if (!$result['success']) {
            return response()->json(['message' => $result['error']], 422);
        }

        $animalId = null;
        if ($request->filled('animal_uuid')) {
            $animal = Animal::where('uuid', $request->input('animal_uuid'))->first();
            $animalId = $animal?->id;
        }

        $mediaPath = $request->file('media')->store('ai_scans', 'public');

        $scan = AIScan::create([
            'animal_id' => $animalId,
            'user_id' => $request->user()->id,
            'scan_type' => $request->input('scan_type', 'health_check'),
            'media_url' => Storage::url($mediaPath),
            'ai_prediction' => json_encode($result['analysis']),
            'confidence_score' => $result['analysis']['confidence_score'],
            'scan_date' => now(),
        ]);

        return response()->json([
            'scan' => new AIScanResource($scan->load(['animal', 'user'])),
            'analysis' => $result['analysis'],
        ], 201);
    }

    public function show(string $animalUuid, AIScan $aiScan): JsonResponse
    {
        $animal = Animal::where('uuid', $animalUuid)->firstOrFail();

        if ($aiScan->animal_id !== $animal->id) {
            return response()->json(['message' => __('messages.access_denied')], 403);
        }

        return response()->json(new AIScanResource($aiScan->load(['animal', 'user'])));
    }

    public function myScans(Request $request): JsonResponse
    {
        $scans = AIScan::with(['animal'])
            ->where('user_id', $request->user()->id)
            ->orderBy('scan_date', 'desc')
            ->paginate($request->input('per_page', 15));

        return response()->json(AIScanResource::collection($scans)->response()->getData(true));
    }
}
