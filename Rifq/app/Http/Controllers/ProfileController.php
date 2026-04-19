<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function requestTeamUpgrade(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->isDataEntry() || $user->isAdmin()) {
            return Redirect::route('profile.edit')
                ->with('error', __('messages.already_have_team_access'));
        }

        $request->validate([
            'independent_team_id' => 'required|exists:independent_teams,id',
            'reason' => 'nullable|string|max:1000',
        ]);

        $user->independent_team_id = $request->input('independent_team_id');
        $user->syncRoles(['data_entry']);
        $user->save();

        return Redirect::route('profile.edit')
            ->with('status', 'team-upgrade-requested');
    }
}
