<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LinksController extends Controller
{
    /**
     * Display links list
     */
    public function index(Request $request)
    {
        $query = Link::with(['user', 'analytics']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('url', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->get('user_id'));
        }

        // Filter by visibility (using is_active instead of is_visible)
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        // Sort functionality
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        if ($sortBy === 'clicks') {
            $query->orderBy('click_count', $sortDirection);
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        $links = $query->paginate(20)->withQueryString();

        // Get users for filter dropdown
        $users = User::select('id', 'name', 'email')->orderBy('name')->get();

        return Inertia::render('Admin/Links/Index', [
            'links' => $links,
            'users' => $users,
            'filters' => $request->only(['search', 'user_id', 'is_active', 'sort_by', 'sort_direction']),
            'statistics' => [
                'total_links' => Link::count(),
                'active_links' => Link::where('is_active', true)->count(),
                'inactive_links' => Link::where('is_active', false)->count(),
                'total_clicks' => Link::sum('click_count'),
            ],
        ]);
    }

    /**
     * Display link details
     */
    public function show(Link $link)
    {
        $link->load(['user.profile']);
        $link->total_clicks = $link->click_count;

        return Inertia::render('Admin/Links/Show', [
            'link' => $link,
        ]);
    }

    /**
     * Update link
     */
    public function update(Request $request, Link $link)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url', 'max:1000'],
            'description' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
            'order' => ['integer', 'min:0'],
        ]);

        $link->update($validated);

        return redirect()->back()->with('success', 'Link updated successfully.');
    }

    /**
     * Delete link
     */
    public function destroy(Link $link)
    {
        $link->delete();

        return redirect()->route('admin.links.index')->with('success', 'Link deleted successfully.');
    }

    /**
     * Toggle link visibility
     */
    public function toggleVisibility(Link $link)
    {
        $link->update(['is_active' => ! $link->is_active]);

        $status = $link->is_active ? 'activated' : 'deactivated';

        return redirect()->back()->with('success', "Link {$status} successfully.");
    }

    /**
     * Bulk actions for links
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => ['required', 'in:delete,deactivate,activate'],
            'link_ids' => ['required', 'array'],
            'link_ids.*' => ['exists:links,id'],
        ]);

        $links = Link::whereIn('id', $validated['link_ids']);

        switch ($validated['action']) {
            case 'delete':
                $count = $links->count();
                $links->delete();

                return redirect()->back()->with('success', "{$count} links deleted successfully.");

            case 'deactivate':
                $count = $links->update(['is_active' => false]);

                return redirect()->back()->with('success', "{$count} links deactivated successfully.");

            case 'activate':
                $count = $links->update(['is_active' => true]);

                return redirect()->back()->with('success', "{$count} links activated successfully.");
        }
    }
}
