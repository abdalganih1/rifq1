<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalQrLink;
use App\Models\IndependentTeam;
use App\Models\Governorate;
use App\Services\QRCodeService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AnimalController extends Controller
{
    public function index(Request $request): View
    {
        $user = auth()->user();
        $query = Animal::with(['independentTeam', 'creator']);

        if ($user->isDataEntry() && !$user->isAdmin()) {
            $query->where('independent_team_id', $user->independent_team_id);
        }

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
            $query->where('data_entered_status', $request->input('status') === 'entered');
        }

        if ($request->filled('team_id')) {
            $query->where('independent_team_id', $request->input('team_id'));
        }

        $animals = $query->orderBy('created_at', 'desc')->paginate(50);
        $teams = IndependentTeam::all();

        return view('animals.index', compact('animals', 'teams'));
    }

    public function edit(Animal $animal): View
    {
        $animal->load(['independentTeam', 'creator']);
        $teams = IndependentTeam::with('governorate')->get();

        return view('animals.data_entry', compact('animal', 'teams'));
    }

    public function storeOrUpdate(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'uuid' => 'nullable|string|exists:animals,uuid',
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
            'image' => 'nullable|image|max:5120',
            'medical_procedures' => 'nullable|array',
            'parasite_treatments' => 'nullable|array',
            'vaccinations_details' => 'nullable|array',
            'medical_supervisor_info' => 'nullable|array',
        ]);

        $uuid = $validated['uuid'] ?? null;

        if ($uuid) {
            $animal = Animal::where('uuid', $uuid)->firstOrFail();
        } else {
            $animal = new Animal();
            $animal->uuid = Str::uuid()->toString();
            $animal->qr_code_hash = Str::uuid()->toString();
            $animal->created_by = auth()->id();
        }

        $animal->fill(collect($validated)->except(['uuid', 'image'])->toArray());
        $animal->last_updated_by = auth()->id();
        $animal->data_entered_status = true;

        if (!$animal->independent_team_id && auth()->user()->independent_team_id) {
            $animal->independent_team_id = auth()->user()->independent_team_id;
        }

        if ($request->hasFile('image')) {
            if ($animal->image_path) {
                Storage::disk('public')->delete($animal->image_path);
            }
            $animal->image_path = $request->file('image')->store('animals', 'public');
        }

        $animal->save();

        if (!$animal->serial_number) {
            $animal->generateSerialNumber();
        }

        return redirect()->route('animals.index')
            ->with('success', __('messages.animal_saved_successfully'));
    }

    public function show(string $uuid): View
    {
        $animal = Animal::where('uuid', $uuid)
            ->with(['independentTeam', 'creator', 'medicalRecords'])
            ->firstOrFail();

        return view('animals.show', compact('animal'));
    }

    public function showPublic(string $uuid): View
    {
        $animal = Animal::where('uuid', $uuid)
            ->with(['independentTeam.governorate', 'medicalRecords'])
            ->first();

        if (!$animal) {
            $animal = Animal::onlyTrashed()->where('uuid', $uuid)->first();
            if ($animal) {
                return view('animals.public_view_deleted', compact('animal'));
            }
            abort(404);
        }

        if (!$animal->data_entered_status) {
            return view('animals.public_view_pending', compact('animal'));
        }

        return view('animals.public_view', compact('animal'));
    }

    public function destroy(string $uuid): RedirectResponse
    {
        $animal = Animal::where('uuid', $uuid)->firstOrFail();
        $animal->delete();

        return redirect()->route('animals.index')
            ->with('success', __('messages.animal_deleted_successfully'));
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $uuids = $request->input('selected_animals', []);

        if (empty($uuids)) {
            return redirect()->route('animals.index')
                ->with('error', __('messages.no_animals_selected'));
        }

        Animal::whereIn('uuid', $uuids)->delete();

        return redirect()->route('animals.index')
            ->with('success', __('messages.bulk_delete_success'));
    }

    public function showQRGenerationForm(): View
    {
        $teams = IndependentTeam::with('governorate')->get();
        return view('animals.generate_qrs', compact('teams'));
    }

    public function generateQRCodes(Request $request)
    {
        $validated = $request->validate([
            'count' => 'required|integer|min:1|max:100',
            'independent_team_id' => 'required|exists:independent_teams,id',
        ]);

        $team = IndependentTeam::findOrFail($validated['independent_team_id']);
        $qrLinks = [];

        for ($i = 0; $i < $validated['count']; $i++) {
            $animal = new Animal();
            $animal->uuid = Str::uuid()->toString();
            $animal->qr_code_hash = Str::uuid()->toString();
            $animal->independent_team_id = $team->id;
            $animal->created_by = auth()->id();
            $animal->data_entered_status = false;
            $animal->save();

            $animal->generateSerialNumber();

            $qrIdentifier = Str::uuid()->toString();
            $qrImageDir = 'qrcodes';
            $qrFileName = $qrIdentifier . '.svg';
            $qrPath = $qrImageDir . '/' . $qrFileName;

            Storage::disk('public')->makeDirectory($qrImageDir);

            $qrContent = QrCode::size(300)
                ->format('svg')
                ->generate(route('animals.public-view', $animal->uuid));

            Storage::disk('public')->put($qrPath, $qrContent);

            AnimalQrLink::create([
                'animal_id' => $animal->id,
                'qr_identifier' => $qrIdentifier,
                'qr_image_path' => $qrPath,
            ]);

            $qrLinks[] = [
                'animal' => $animal,
                'qr_identifier' => $qrIdentifier,
                'qr_image_url' => Storage::url($qrPath),
                'serial_number' => $animal->serial_number,
            ];
        }

        return view('animals.qr_print_preview', compact('qrLinks', 'team'));
    }

    public function printQRCodes(Request $request)
    {
        $validated = $request->validate([
            'qr_identifiers' => 'required|array',
            'qr_identifiers.*' => 'exists:animal_qr_links,qr_identifier',
        ]);

        $qrLinks = AnimalQrLink::whereIn('qr_identifier', $validated['qr_identifiers'])
            ->with('animal')
            ->get();

        $pdf = Pdf::loadView('animals.qr_pdf_template', compact('qrLinks'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('qr-codes-' . date('Y-m-d') . '.pdf');
    }

    public function trashIndex(): View
    {
        $animals = Animal::onlyTrashed()
            ->with(['independentTeam', 'creator'])
            ->orderBy('deleted_at', 'desc')
            ->paginate(50);

        return view('admin.trash.index', compact('animals'));
    }

    public function trashRestore(int $id): RedirectResponse
    {
        $animal = Animal::onlyTrashed()->findOrFail($id);
        $animal->restore();

        return redirect()->route('admin.trash.index')
            ->with('success', __('messages.animal_restored_successfully'));
    }

    public function trashDestroy(int $id): RedirectResponse
    {
        $animal = Animal::onlyTrashed()->findOrFail($id);

        if ($animal->image_path) {
            Storage::disk('public')->delete($animal->image_path);
        }

        $animal->forceDelete();

        return redirect()->route('admin.trash.index')
            ->with('success', __('messages.animal_permanently_deleted'));
    }
}
