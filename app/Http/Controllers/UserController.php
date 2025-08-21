<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function show()
    {
        return response()->json(auth()->user());
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'bio' => 'nullable|string|max:1000',
        ]);

        $user->update($request->only(['name', 'email', 'bio']));

        return response()->json([
            'user' => $user,
            'message' => 'Profile updated successfully'
        ]);
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|string', // Base64 encoded image
        ]);

        $user = auth()->user();
        
        // In a real app, you'd save the image to storage
        // For now, we'll just store the base64 string
        $user->update(['photo' => $request->photo]);

        return response()->json([
            'user' => $user,
            'message' => 'Profile photo updated successfully'
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Current password is incorrect'
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'Password updated successfully'
        ]);
    }
}