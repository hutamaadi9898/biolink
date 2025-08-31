<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    /**
     * Display users list
     */
    public function index(Request $request)
    {
        $query = User::with(['profile', 'links', 'portfolios']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->get('role'));
        }

        // Filter by admin status
        if ($request->filled('is_admin')) {
            $query->where('is_admin', $request->boolean('is_admin'));
        }

        // Sort functionality
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $users = $query->paginate(20)->withQueryString();

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
            'filters' => $request->only(['search', 'role', 'is_admin', 'sort_by', 'sort_direction']),
            'statistics' => [
                'total_users' => User::count(),
                'admin_users' => User::where('is_admin', true)->count(),
                'pro_users' => User::where('role', 'pro')->count(),
                'verified_users' => User::whereNotNull('email_verified_at')->count(),
            ],
        ]);
    }

    /**
     * Display user details
     */
    public function show(User $user)
    {
        $user->load([
            'profile',
            'links.analytics',
            'portfolios',
            'analytics',
            'userThemes.theme'
        ]);

        $user->loadCount(['links', 'portfolios']);
        $user->total_clicks = $user->analytics->sum('clicks');

        return Inertia::render('Admin/Users/Show', [
            'user' => $user,
        ]);
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'username' => ['nullable', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'in:user,pro'],
            'is_admin' => ['boolean'],
            'email_verified_at' => ['nullable', 'date'],
        ]);

        if ($request->has('email_verified_at')) {
            $validated['email_verified_at'] = $request->filled('email_verified_at') 
                ? now() 
                : null;
        }

        $user->update($validated);

        return redirect()->back()->with('success', 'User updated successfully.');
    }

    /**
     * Delete user
     */
    public function destroy(User $user)
    {
        // Prevent deleting the last admin
        if ($user->is_admin && User::where('is_admin', true)->count() === 1) {
            return redirect()->back()->withErrors(['error' => 'Cannot delete the last admin user.']);
        }

        // Delete related data
        $user->profile()->delete();
        $user->links()->delete();
        $user->portfolios()->delete();
        $user->analytics()->delete();
        $user->userThemes()->delete();

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Toggle admin status
     */
    public function toggleAdmin(User $user)
    {
        // Prevent removing admin status from the last admin
        if ($user->is_admin && User::where('is_admin', true)->count() === 1) {
            return redirect()->back()->withErrors(['error' => 'Cannot remove admin status from the last admin user.']);
        }

        $user->update(['is_admin' => !$user->is_admin]);

        $status = $user->is_admin ? 'granted' : 'removed';
        return redirect()->back()->with('success', "Admin privileges {$status} successfully.");
    }

    /**
     * Toggle user verification
     */
    public function toggleVerification(User $user)
    {
        $user->update([
            'email_verified_at' => $user->email_verified_at ? null : now(),
        ]);

        $status = $user->email_verified_at ? 'verified' : 'unverified';
        return redirect()->back()->with('success', "User email {$status} successfully.");
    }

    /**
     * Impersonate user (login as user)
     */
    public function impersonate(User $user)
    {
        // Store original admin user ID in session
        session(['impersonate_admin_id' => auth()->id()]);
        
        // Login as the selected user
        auth()->login($user);

        return redirect()->route('dashboard')->with('success', "You are now logged in as {$user->name}.");
    }

    /**
     * Stop impersonating and return to admin account
     */
    public function stopImpersonating()
    {
        $adminId = session('impersonate_admin_id');
        
        if (!$adminId) {
            return redirect()->route('admin.dashboard');
        }

        $admin = User::find($adminId);
        
        if ($admin) {
            auth()->login($admin);
            session()->forget('impersonate_admin_id');
        }

        return redirect()->route('admin.dashboard')->with('success', 'Stopped impersonating user.');
    }
}
