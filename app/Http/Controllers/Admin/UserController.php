<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of all registered users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by user type
        if ($request->filled('type')) {
            if ($request->type === 'admin') {
                $query->where('is_admin', true);
            } elseif ($request->type === 'user') {
                $query->where('is_admin', false);
            }
        }

        // Sort options
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $users = $query->paginate(15)->withQueryString();

        // Get statistics
        $totalUsers = User::count();
        $totalAdmins = User::where('is_admin', true)->count();
        $newThisWeek = User::where('created_at', '>=', now()->subDays(7))->count();

        return view('admin.users.index', compact('users', 'totalUsers', 'totalAdmins', 'newThisWeek'));
    }

    /**
     * Display the specified user details.
     */
    public function show(User $user)
    {
        // Load user relationships
        $user->load(['payments' => function($q) {
            $q->latest()->limit(10);
        }, 'skills' => function($q) {
            $q->withPivot('status', 'approved_at');
        }]);

        $paymentStats = [
            'total' => $user->payments()->count(),
            'approved' => $user->payments()->where('status', 'approved')->count(),
            'pending' => $user->payments()->where('status', 'pending')->count(),
            'total_amount' => $user->payments()->where('status', 'approved')->sum('amount'),
        ];

        $skillStats = [
            'approved' => $user->skills()->wherePivot('status', 'approved')->count(),
            'pending' => $user->skills()->wherePivot('status', 'pending')->count(),
        ];

        return view('admin.users.show', compact('user', 'paymentStats', 'skillStats'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|unique:users,phone,' . $user->id . '|regex:/^[0-9]{10,15}$/',
            'whatsapp' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'is_admin' => 'boolean',
        ]);

        $user->update($request->only(['name', 'email', 'phone', 'whatsapp', 'location', 'is_admin']));

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Toggle admin status for a user.
     */
    public function toggleAdmin(User $user)
    {
        // Prevent admin from changing their own status
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own admin status.');
        }

        $user->update(['is_admin' => !$user->is_admin]);

        $status = $user->is_admin ? 'Admin privileges granted.' : 'Admin privileges removed.';
        return back()->with('success', $status);
    }
}