<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Services\EmbedService;
use Illuminate\Http\Re    public function destroy(Link $link)
    {
        // Ensure the link belongs to the authenticated user
        if ($link->user_id !== auth()->id()) {
            abort(403);
        }

        // Delete image file if exists
        if ($link->image) {
            Storage::disk('public')->delete($link->image);
        }

        $link->delete();

        return back()->with('success', 'Link berhasil dihapus!');
    }Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class LinkController extends Controller
{
    /**
     * Display a listing of the user's links.
     */
    public function index(): Response
    {
        $links = auth()->user()->links()
            ->ordered()
            ->get();

        return Inertia::render('Dashboard/Links', [
            'links' => $links,
        ]);
    }

    /**
     * Store a newly created link in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:500',
            'type' => 'required|string|in:social,custom',
            'show_as_embed' => 'boolean',
            'image' => 'nullable|image|max:5120', // 5MB max
        ]);

        $user = $request->user();

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('links', 'public');
            $validated['image'] = $path;
        }

        // Process embed data if requested
        if ($validated['show_as_embed'] ?? false) {
            $embedData = $this->embedService->parseEmbedData($validated['url']);
            if ($embedData) {
                $validated['embed_type'] = $embedData['type'];
                $validated['embed_data'] = $embedData['data'];
            }
        }

        $user->links()->create($validated);

        return back()->with('success', 'Link berhasil ditambahkan!');
    }

    /**
     * Update the specified link in storage.
     */
    public function update(Request $request, Link $link)
    {
        // Ensure the link belongs to the authenticated user
        if ($link->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:500',
            'type' => 'required|string|in:social,custom',
            'show_as_embed' => 'boolean',
            'image' => 'nullable|image|max:5120', // 5MB max
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($link->image) {
                Storage::disk('public')->delete($link->image);
            }
            
            $path = $request->file('image')->store('links', 'public');
            $validated['image'] = $path;
        }

        // Process embed data if requested
        if ($validated['show_as_embed'] ?? false) {
            $embedData = $this->embedService->parseEmbedData($validated['url']);
            if ($embedData) {
                $validated['embed_type'] = $embedData['type'];
                $validated['embed_data'] = $embedData['data'];
            } else {
                $validated['embed_type'] = null;
                $validated['embed_data'] = null;
            }
        } else {
            $validated['embed_type'] = null;
            $validated['embed_data'] = null;
        }

        $link->update($validated);

        return back()->with('success', 'Link berhasil diperbarui!');
    }

    /**
     * Remove the specified link from storage.
     */
    public function destroy(Link $link)
    {
        // Ensure the link belongs to the authenticated user
        if ($link->user_id !== auth()->id()) {
            abort(403);
        }

        $link->delete();

        return redirect()->back()->with('success', 'Link berhasil dihapus!');
    }

    /**
     * Reorder the user's links.
     */
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'links' => 'required|array',
            'links.*.id' => 'required|exists:links,id',
            'links.*.order' => 'required|integer|min:1',
        ]);

        foreach ($validated['links'] as $linkData) {
            Link::where('id', $linkData['id'])
                ->where('user_id', auth()->id())
                ->update(['order' => $linkData['order']]);
        }

        return redirect()->back()->with('success', 'Urutan link berhasil diperbarui!');
    }

    /**
     * Toggle the active status of a link.
     */
    public function toggle(Link $link)
    {
        // Ensure the link belongs to the authenticated user
        if ($link->user_id !== auth()->id()) {
            abort(403);
        }

        $link->update(['is_active' => !$link->is_active]);

        $status = $link->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->back()->with('success', "Link berhasil {$status}!");
    }
}
