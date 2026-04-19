<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\IndependentTeam;
use App\Models\Governorate;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PageController extends Controller
{
    public function landing(): View
    {
        $totalAnimals = Animal::count();
        $adoptedAnimals = Animal::where('status', 'Adopted')->count();
        $totalTeams = IndependentTeam::count();
        $totalGovernorates = Governorate::has('independentTeams')->count();

        $recentAnimals = Animal::with(['independentTeam'])
            ->where('data_entered_status', true)
            ->whereNotNull('image_path')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('landing', compact(
            'totalAnimals', 'adoptedAnimals', 'totalTeams',
            'totalGovernorates', 'recentAnimals'
        ));
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function team(): View
    {
        $teams = IndependentTeam::with(['governorate', 'users'])->get();
        return view('pages.team', compact('teams'));
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function switchLang(string $locale): RedirectResponse
    {
        if (in_array($locale, ['ar', 'en'])) {
            session(['locale' => $locale]);
        }

        return redirect()->back();
    }
}
