<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CardController extends Controller
{
    public function index()
    {
        $cards = auth()->user()->cards()->latest()->get();
        return response()->json($cards);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url',
            'address' => 'nullable|string|max:500',
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|string',
            'template' => 'required|string|in:modern,classic,creative,minimal',
            'color_scheme' => 'required|string|in:blue,green,purple,orange,red',
        ]);

        $card = auth()->user()->cards()->create($request->all());

        return response()->json($card, 201);
    }

    public function show(Card $card)
    {
        // Check if user owns the card or if it's public
        if ($card->user_id !== auth()->id() && !$card->is_public) {
            return response()->json(['message' => 'Card not found'], 404);
        }

        return response()->json($card);
    }

    public function update(Request $request, Card $card)
    {
        // Check if user owns the card
        if ($card->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url',
            'address' => 'nullable|string|max:500',
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|string',
            'template' => 'required|string|in:modern,classic,creative,minimal',
            'color_scheme' => 'required|string|in:blue,green,purple,orange,red',
        ]);

        $card->update($request->all());

        return response()->json($card);
    }

    public function destroy(Card $card)
    {
        // Check if user owns the card
        if ($card->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $card->delete();

        return response()->json(['message' => 'Card deleted successfully']);
    }

    public function view(Card $card)
    {
        // Increment view count
        $card->increment('views');

        return response()->json($card);
    }

    public function stats(Card $card)
    {
        // Check if user owns the card
        if ($card->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'views' => $card->views,
            'shares' => $card->shares,
            'downloads' => $card->downloads,
        ]);
    }

    public function share(Card $card)
    {
        // Check if user owns the card
        if ($card->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Increment share count
        $card->increment('shares');

        return response()->json(['message' => 'Share recorded successfully']);
    }
}