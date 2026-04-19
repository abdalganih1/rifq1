<?php

use App\Http\Controllers\Api\ApiAdoptionController;
use App\Http\Controllers\Api\ApiAIScanController;
use App\Http\Controllers\Api\ApiAnimalController;
use App\Http\Controllers\Api\ApiLookupController;
use App\Http\Controllers\Api\ApiMedicalRecordController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::get('/animals/public/{uuid}', [ApiAnimalController::class, 'publicShow']);
Route::get('/scan/{hash}', [ApiAnimalController::class, 'scanByHash']);
Route::get('/governorates', [ApiLookupController::class, 'governorates']);
Route::get('/teams', [ApiLookupController::class, 'teams']);
Route::get('/organizations', [ApiLookupController::class, 'organizations']);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::put('/profile', [AuthController::class, 'updateProfile']);
        Route::put('/password', [AuthController::class, 'changePassword']);
    });

    Route::get('/dashboard-stats', [ApiLookupController::class, 'dashboardStats']);

    Route::apiResource('animals', ApiAnimalController::class)->parameter('animal', 'uuid')->except(['show']);
    Route::get('/animals/{uuid}', [ApiAnimalController::class, 'show']);

    Route::get('/animals/{animalUuid}/medical-records', [ApiMedicalRecordController::class, 'index']);
    Route::post('/animals/{animalUuid}/medical-records', [ApiMedicalRecordController::class, 'store']);
    Route::get('/animals/{animalUuid}/medical-records/{medicalRecord}', [ApiMedicalRecordController::class, 'show']);
    Route::put('/animals/{animalUuid}/medical-records/{medicalRecord}', [ApiMedicalRecordController::class, 'update']);
    Route::delete('/animals/{animalUuid}/medical-records/{medicalRecord}', [ApiMedicalRecordController::class, 'destroy']);

    Route::get('/animals/{animalUuid}/ai-scans', [ApiAIScanController::class, 'index']);
    Route::get('/animals/{animalUuid}/ai-scans/{aiScan}', [ApiAIScanController::class, 'show']);
    Route::post('/ai/analyze', [ApiAIScanController::class, 'analyze']);
    Route::get('/ai/my-scans', [ApiAIScanController::class, 'myScans']);

    Route::get('/adoptions', [ApiAdoptionController::class, 'index']);
    Route::get('/adoptions/{animal}', [ApiAdoptionController::class, 'show']);
    Route::post('/adoptions/{animal}/request', [ApiAdoptionController::class, 'submitRequest']);
    Route::get('/adoptions/my-requests', [ApiAdoptionController::class, 'myRequests']);
    Route::post('/adoptions/requests/{adoptionRequest}/cancel', [ApiAdoptionController::class, 'cancelRequest']);
});
