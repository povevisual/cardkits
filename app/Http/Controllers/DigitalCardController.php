<?php

namespace App\Http\Controllers;

use App\Models\DigitalCard;
use App\Models\CardTemplate;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class DigitalCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $digitalCards = DigitalCard::where('user_id', auth()->id())
            ->with(['template', 'components'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalViews = $digitalCards->sum('view_count');
        $totalAppointments = Appointment::whereHas('digitalCard', function ($query) {
            $query->where('user_id', auth()->id());
        })->count();
        $activeCards = $digitalCards->where('is_active', true)->count();

        return view('digital-cards.index', compact('digitalCards', 'totalViews', 'totalAppointments', 'activeCards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $templates = CardTemplate::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('digital-cards.create', compact('templates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:card_templates,id',
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'address_line_1' => 'nullable|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'is_password_protected' => 'boolean',
            'password' => 'required_if:is_password_protected,1|string|min:6|confirmed',
            'is_public' => 'boolean',
            'enable_analytics' => 'boolean',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['slug'] = $this->generateUniqueSlug($request->name);
        $data['is_active'] = true;

        // Handle file uploads
        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }
        if ($request->hasFile('cover_photo')) {
            $data['cover_photo'] = $request->file('cover_photo')->store('cover-photos', 'public');
        }
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $digitalCard = DigitalCard::create($data);

        return redirect()->route('digital-cards.show', $digitalCard)
            ->with('success', 'Digital card created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(DigitalCard $digitalCard)
    {
        // Check if user owns the card
        if ($digitalCard->user_id !== auth()->id()) {
            abort(403);
        }

        $digitalCard->load(['template', 'components' => function ($query) {
            $query->orderBy('order');
        }]);

        $appointments = Appointment::where('digital_card_id', $digitalCard->id)
            ->orderBy('start_time', 'desc')
            ->get();

        return view('digital-cards.show', compact('digitalCard', 'appointments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DigitalCard $digitalCard)
    {
        // Check if user owns the card
        if ($digitalCard->user_id !== auth()->id()) {
            abort(403);
        }

        $templates = CardTemplate::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('digital-cards.edit', compact('digitalCard', 'templates'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DigitalCard $digitalCard)
    {
        // Check if user owns the card
        if ($digitalCard->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'template_id' => 'required|exists:card_templates,id',
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'address_line_1' => 'nullable|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'is_password_protected' => 'boolean',
            'password' => 'nullable|string|min:6|confirmed',
            'is_public' => 'boolean',
            'enable_analytics' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();

        // Handle file uploads
        if ($request->hasFile('profile_photo')) {
            // Delete old file
            if ($digitalCard->profile_photo) {
                Storage::disk('public')->delete($digitalCard->profile_photo);
            }
            $data['profile_photo'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }
        if ($request->hasFile('cover_photo')) {
            if ($digitalCard->cover_photo) {
                Storage::disk('public')->delete($digitalCard->cover_photo);
            }
            $data['cover_photo'] = $request->file('cover_photo')->store('cover-photos', 'public');
        }
        if ($request->hasFile('logo')) {
            if ($digitalCard->logo) {
                Storage::disk('public')->delete($digitalCard->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // Only update password if provided
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $digitalCard->update($data);

        return redirect()->route('digital-cards.show', $digitalCard)
            ->with('success', 'Digital card updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DigitalCard $digitalCard)
    {
        // Check if user owns the card
        if ($digitalCard->user_id !== auth()->id()) {
            abort(403);
        }

        // Delete associated files
        if ($digitalCard->profile_photo) {
            Storage::disk('public')->delete($digitalCard->profile_photo);
        }
        if ($digitalCard->cover_photo) {
            Storage::disk('public')->delete($digitalCard->cover_photo);
        }
        if ($digitalCard->logo) {
            Storage::disk('public')->delete($digitalCard->logo);
        }

        $digitalCard->delete();

        return redirect()->route('digital-cards.index')
            ->with('success', 'Digital card deleted successfully!');
    }

    /**
     * Toggle the active status of a digital card.
     */
    public function toggleStatus(DigitalCard $digitalCard)
    {
        // Check if user owns the card
        if ($digitalCard->user_id !== auth()->id()) {
            abort(403);
        }

        $digitalCard->update([
            'is_active' => !$digitalCard->is_active
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $digitalCard->is_active,
            'message' => 'Card status updated successfully.'
        ]);
    }

    /**
     * Duplicate a digital card.
     */
    public function duplicate(DigitalCard $digitalCard)
    {
        // Check if user owns the card
        if ($digitalCard->user_id !== auth()->id()) {
            abort(403);
        }

        // Create a copy of the card
        $newCard = $digitalCard->replicate();
        $newCard->name = $digitalCard->name . ' (Copy)';
        $newCard->slug = $this->generateUniqueSlug($newCard->name);
        $newCard->is_active = false; // Start as inactive
        $newCard->view_count = 0;
        $newCard->save();

        // Copy components
        foreach ($digitalCard->components as $component) {
            $newComponent = $component->replicate();
            $newComponent->digital_card_id = $newCard->id;
            $newComponent->click_count = 0;
            $newComponent->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Card duplicated successfully.',
            'redirect_url' => route('digital-cards.edit', $newCard)
        ]);
    }

    /**
     * Generate a unique slug for the digital card.
     */
    private function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (DigitalCard::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}