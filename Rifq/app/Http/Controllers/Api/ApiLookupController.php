<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnimalResource;
use App\Http\Resources\GovernorateResource;
use App\Http\Resources\IndependentTeamResource;
use App\Http\Resources\OrganizationResource;
use App\Models\Governorate;
use App\Models\IndependentTeam;
use App\Models\Organization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiLookupController extends Controller
{
    public function governorates(): JsonResponse
    {
        $governorates = Governorate::withCount('independentTeams')->get();

        return response()->json(GovernorateResource::collection($governorates));
    }

    public function teams(Request $request): JsonResponse
    {
        $query = IndependentTeam::with('governorate');

        if ($request->filled('governorate_id')) {
            $query->where('governorate_id', $request->input('governorate_id'));
        }

        $teams = $query->withCount('animals')->get();

        return response()->json(IndependentTeamResource::collection($teams));
    }

    public function organizations(): JsonResponse
    {
        $organizations = Organization::withCount('animals')->get();

        return response()->json(OrganizationResource::collection($organizations));
    }

    public function dashboardStats(): JsonResponse
    {
        $stats = [
            'total_animals' => \App\Models\Animal::count(),
            'adopted_animals' => \App\Models\Animal::where('status', 'Adopted')->count(),
            'available_for_adoption' => \App\Models\Animal::where('status', 'available_for_adoption')->count(),
            'total_teams' => IndependentTeam::count(),
            'total_governorates' => Governorate::has('independentTeams')->count(),
            'total_organizations' => Organization::count(),
            'pending_adoption_requests' => \App\Models\AdoptionRequest::where('status', 'pending')->count(),
        ];

        return response()->json($stats);
    }
}
