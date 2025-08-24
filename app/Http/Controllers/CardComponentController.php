<?php

namespace App\Http\Controllers;

use App\Models\CardComponent;
use App\Models\DigitalCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CardComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $components = CardComponent::with('digitalCard')
            ->whereHas('digitalCard', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->orderBy('order')
            ->paginate(20);

        return view('card-components.index', compact('components'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $digitalCards = DigitalCard::where('user_id', auth()->id())
            ->where('is_active', true)
            ->get();

        $componentTypes = CardComponent::TYPES;

        return view('card-components.create', compact('digitalCards', 'componentTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'digital_card_id' => 'required|exists:digital_cards,id',
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:' . implode(',', CardComponent::TYPES),
            'content' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'media_url' => 'nullable|url',
            'media_alt' => 'nullable|string|max:255',
            'config' => 'nullable|array',
            'styling' => 'nullable|array',
            'animation' => 'nullable|array',
            'order' => 'nullable|integer|min:0',
            'position' => 'nullable|string|max:255',
            'layout' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        // Check if user owns the digital card
        $digitalCard = DigitalCard::where('id', $request->digital_card_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $component = CardComponent::create([
            'digital_card_id' => $request->digital_card_id,
            'name' => $request->name,
            'type' => $request->type,
            'content' => $request->content,
            'icon' => $request->icon,
            'media_url' => $request->media_url,
            'media_alt' => $request->media_alt,
            'config' => $request->config ?? [],
            'styling' => $request->styling ?? [],
            'animation' => $request->animation ?? [],
            'order' => $request->order ?? 0,
            'position' => $request->position,
            'layout' => $request->layout ?? [],
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('card-components.show', $component)
            ->with('success', 'Component created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CardComponent $cardComponent)
    {
        // Check if user owns the component
        if ($cardComponent->digitalCard->user_id !== auth()->id()) {
            abort(403);
        }

        return view('card-components.show', compact('cardComponent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CardComponent $cardComponent)
    {
        // Check if user owns the component
        if ($cardComponent->digitalCard->user_id !== auth()->id()) {
            abort(403);
        }

        $digitalCards = DigitalCard::where('user_id', auth()->id())
            ->where('is_active', true)
            ->get();

        $componentTypes = CardComponent::TYPES;

        return view('card-components.edit', compact('cardComponent', 'digitalCards', 'componentTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CardComponent $cardComponent)
    {
        // Check if user owns the component
        if ($cardComponent->digitalCard->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'digital_card_id' => 'required|exists:digital_cards,id',
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:' . implode(',', CardComponent::TYPES),
            'content' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'media_url' => 'nullable|url',
            'media_alt' => 'nullable|string|max:255',
            'config' => 'nullable|array',
            'styling' => 'nullable|array',
            'animation' => 'nullable|array',
            'order' => 'nullable|integer|min:0',
            'position' => 'nullable|string|max:255',
            'layout' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        // Check if user owns the digital card
        $digitalCard = DigitalCard::where('id', $request->digital_card_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $cardComponent->update([
            'digital_card_id' => $request->digital_card_id,
            'name' => $request->name,
            'type' => $request->type,
            'content' => $request->content,
            'icon' => $request->icon,
            'media_url' => $request->media_url,
            'media_alt' => $request->media_alt,
            'config' => $request->config ?? [],
            'styling' => $request->styling ?? [],
            'animation' => $request->animation ?? [],
            'order' => $request->order ?? 0,
            'position' => $request->position,
            'layout' => $request->layout ?? [],
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('card-components.show', $cardComponent)
            ->with('success', 'Component updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CardComponent $cardComponent)
    {
        // Check if user owns the component
        if ($cardComponent->digitalCard->user_id !== auth()->id()) {
            abort(403);
        }

        $cardComponent->delete();

        return redirect()->route('digital-cards.show', $cardComponent->digital_card_id)
            ->with('success', 'Component deleted successfully.');
    }

    /**
     * Toggle the active status of a component.
     */
    public function toggleStatus(CardComponent $cardComponent)
    {
        // Check if user owns the component
        if ($cardComponent->digitalCard->user_id !== auth()->id()) {
            abort(403);
        }

        $cardComponent->update([
            'is_active' => !$cardComponent->is_active
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $cardComponent->is_active,
            'message' => 'Component status updated successfully.'
        ]);
    }

    /**
     * Reorder components.
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'components' => 'required|array',
            'components.*.id' => 'required|exists:card_components,id',
            'components.*.order' => 'required|integer|min:0',
        ]);

        foreach ($request->components as $componentData) {
            $component = CardComponent::find($componentData['id']);
            
            // Check if user owns the component
            if ($component && $component->digitalCard->user_id === auth()->id()) {
                $component->update(['order' => $componentData['order']]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Components reordered successfully.'
        ]);
    }
}