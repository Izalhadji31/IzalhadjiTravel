<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show user profile
     */
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    /**
     * Show edit form
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'country' => 'nullable|string',
        ]);

        $user->update($validated);
        return redirect()->route('profile.show')
                       ->with('success', 'Profile updated successfully');
    }

    /**
     * Upload identity verification
     */
    public function uploadIdentity(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'id_type' => 'required|in:ktp,sim',
            'id_number' => 'required|string|unique:identity_verifications',
            'id_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload photo
        $path = $request->file('id_photo')->store('identities', 'public');

        // Create verification
        $user->identityVerification()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'id_type' => $validated['id_type'],
                'id_number' => $validated['id_number'],
                'id_photo_path' => $path,
                'status' => 'pending',
            ]
        );

        return back()->with('success', 'Identity document uploaded. Please wait for verification');
    }
}
