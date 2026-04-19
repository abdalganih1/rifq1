<?php

namespace App\Http\Controllers;

use App\Models\AdoptionRequest;
use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AdoptionController extends Controller
{
    public function index(): View
    {
        $animals = Animal::with('organization')
            ->where('status', 'available_for_adoption')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('adoptions.index', compact('animals'));
    }

    public function show(Animal $animal): View
    {
        $animal->load(['organization', 'medicalRecords' => function ($query) {
            $query->orderBy('visit_date', 'desc')->limit(5);
        }]);

        $existingRequest = null;
        if (Auth::check()) {
            $existingRequest = AdoptionRequest::where('animal_id', $animal->id)
                ->where('adopter_id', Auth::id())
                ->whereIn('status', ['pending', 'approved'])
                ->first();
        }

        return view('adoptions.show', compact('animal', 'existingRequest'));
    }

    public function submitRequest(Request $request, Animal $animal): RedirectResponse
    {
        $request->validate([
            'request_message' => 'required|string|max:1000',
        ]);

        $existingRequest = AdoptionRequest::where('animal_id', $animal->id)
            ->where('adopter_id', Auth::id())
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingRequest) {
            return back()->with('error', 'لديك طلب قيد المعالجة بالفعل لهذا الحيوان.');
        }

        AdoptionRequest::create([
            'animal_id' => $animal->id,
            'adopter_id' => Auth::id(),
            'status' => 'pending',
            'request_message' => $request->request_message,
            'request_date' => now(),
        ]);

        return redirect()->route('adoptions.my-requests')
            ->with('success', 'تم تقديم طلب التبني بنجاح.');
    }

    public function myRequests(): View
    {
        $requests = AdoptionRequest::with(['animal.organization'])
            ->where('adopter_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('adoptions.my-requests', compact('requests'));
    }
}
