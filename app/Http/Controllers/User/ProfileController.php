<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }
    
    public function update(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
        ]);
        
        $user->update($request->only(['name', 'email', 'phone', 'whatsapp', 'location']));
        
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}