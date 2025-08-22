<?php

namespace App\Http\Controllers;

use App\Models\BioLink;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BioLinkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bioLinks = Auth::user()->bioLinks()->latest()->paginate(10);
        return view('bio-links.index', compact('bioLinks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bio-links.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'background_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'theme_color' => 'nullable|string|max:7',
            'text_color' => 'nullable|string|max:7',
            'button_color' => 'nullable|string|max:7',
            'button_text_color' => 'nullable|string|max:7',
            'font_family' => 'nullable|string|max:100',
            'custom_domain' => 'nullable|string|max:255|unique:bio_links',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['slug'] = $this->generateUniqueSlug($request->title);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('bio-links/profile-photos', 'public');
        }

        // Handle background photo upload
        if ($request->hasFile('background_photo')) {
            $data['background_photo'] = $request->file('background_photo')->store('bio-links/background-photos', 'public');
        }

        $bioLink = BioLink::create($data);

        return redirect()->route('bio-links.show', $bioLink)
            ->with('success', 'Bio Link created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(BioLink $bioLink)
    {
        $this->authorize('view', $bioLink);
        
        $bioLink->load(['items', 'socialMedia']);
        return view('bio-links.show', compact('bioLink'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BioLink $bioLink)
    {
        $this->authorize('update', $bioLink);
        
        return view('bio-links.edit', compact('bioLink'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BioLink $bioLink)
    {
        $this->authorize('update', $bioLink);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'background_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'theme_color' => 'nullable|string|max:7',
            'text_color' => 'nullable|string|max:7',
            'button_color' => 'nullable|string|max:7',
            'button_text_color' => 'nullable|string|max:7',
            'font_family' => 'nullable|string|max:100',
            'custom_domain' => 'nullable|string|max:255|unique:bio_links,custom_domain,' . $bioLink->id,
        ]);

        $data = $request->all();

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo
            if ($bioLink->profile_photo) {
                Storage::disk('public')->delete($bioLink->profile_photo);
            }
            $data['profile_photo'] = $request->file('profile_photo')->store('bio-links/profile-photos', 'public');
        }

        // Handle background photo upload
        if ($request->hasFile('background_photo')) {
            // Delete old photo
            if ($bioLink->background_photo) {
                Storage::disk('public')->delete($bioLink->background_photo);
            }
            $data['background_photo'] = $request->file('background_photo')->store('bio-links/background-photos', 'public');
        }

        $bioLink->update($data);

        return redirect()->route('bio-links.show', $bioLink)
            ->with('success', 'Bio Link updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BioLink $bioLink)
    {
        $this->authorize('delete', $bioLink);

        // Delete photos
        if ($bioLink->profile_photo) {
            Storage::disk('public')->delete($bioLink->profile_photo);
        }
        if ($bioLink->background_photo) {
            Storage::disk('public')->delete($bioLink->background_photo);
        }

        $bioLink->delete();

        return redirect()->route('bio-links.index')
            ->with('success', 'Bio Link deleted successfully!');
    }

    /**
     * Toggle bio link status
     */
    public function toggleStatus(BioLink $bioLink)
    {
        $this->authorize('update', $bioLink);

        $bioLink->update(['is_active' => !$bioLink->is_active]);

        return back()->with('success', 'Bio Link status updated successfully!');
    }

    /**
     * Generate unique slug
     */
    private function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (BioLink::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
