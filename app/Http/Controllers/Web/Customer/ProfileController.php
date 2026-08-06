<?php

namespace App\Http\Controllers\Web\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerBodyProfile;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->bodyProfile; // HasOne relationship

        return view('customer.profile', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'height_cm' => 'required|numeric|min:50|max:300',
            'weight_kg' => 'required|numeric|min:10|max:300',
            'chest_circumference_cm' => 'required|numeric|min:30|max:200',
            'waist_circumference_cm' => 'required|numeric|min:30|max:200',
        ]);

        $user = Auth::user();
        
        // Update user name
        $user->update(['name' => $request->name]);

        // Update or Create Body Profile
        if ($user->bodyProfile) {
            $user->bodyProfile->update($request->only([
                'height_cm', 'weight_kg', 'chest_circumference_cm', 'waist_circumference_cm'
            ]));
        } else {
            $user->bodyProfiles()->create(array_merge(
                $request->only(['height_cm', 'weight_kg', 'chest_circumference_cm', 'waist_circumference_cm']),
                ['profile_name' => 'Profil Utama']
            ));
        }

        return redirect()->back()->with('success', 'Profil tubuh Anda berhasil diperbarui!');
    }
}
