<?php

namespace App\Http\Controllers;

use App\Services\QRCodeService;
use App\Models\Animal;
use Illuminate\View\View;

class QRController extends Controller
{
    public function show(string $hash, QRCodeService $qrService): View
    {
        $animal = $qrService->getAnimalByHash($hash);

        if (!$animal) {
            $animal = Animal::where('uuid', $hash)->first();
        }

        if (!$animal) {
            abort(404, __('messages.animal_not_found'));
        }

        if (!$animal->data_entered_status) {
            return view('animals.public_view_pending', compact('animal'));
        }

        return view('animals.public_view', compact('animal'));
    }
}
