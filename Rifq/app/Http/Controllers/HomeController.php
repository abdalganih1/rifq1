<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\IndependentTeam;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(): RedirectResponse|View
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('filament.admin.pages.dashboard');
        }

        if ($user->isDataEntry() && $user->independentTeam) {
            return $this->teamDashboard($user);
        }

        return view('dashboard');
    }

    public function teamDashboard($user): View
    {
        $team = $user->independentTeam;
        $team->load('governorate');

        $totalAnimals = Animal::where('independent_team_id', $team->id)->count();
        $enteredAnimals = Animal::where('independent_team_id', $team->id)
            ->where('data_entered_status', true)->count();
        $pendingAnimals = Animal::where('independent_team_id', $team->id)
            ->where('data_entered_status', false)->count();

        $recentAnimals = Animal::where('independent_team_id', $team->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('team.dashboard', compact(
            'team', 'totalAnimals', 'enteredAnimals',
            'pendingAnimals', 'recentAnimals'
        ));
    }
}
