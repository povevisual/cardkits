<?php

namespace App\Http\Controllers;

use App\Models\DigitalCard;
use App\Models\CardComponent;
use App\Models\CardAnalytics;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class DigitalCardPublicController extends Controller
{
    /**
     * Display the specified digital card publicly.
     */
    public function show($slug)
    {
        $digitalCard = DigitalCard::where('slug', $slug)
            ->where('is_active', true)
            ->where('is_public', true)
            ->with(['template', 'components' => function ($query) {
                $query->where('is_active', true)->orderBy('order');
            }])
            ->firstOrFail();

        // Check password protection
        if ($digitalCard->is_password_protected) {
            if (!session()->has("card_access_{$digitalCard->id}")) {
                return view('digital-cards.password', compact('digitalCard'));
            }
        }

        // Track view
        $this->trackView($digitalCard);

        return view('digital-cards.public', compact('digitalCard'));
    }

    /**
     * Handle password verification for protected cards.
     */
    public function verifyPassword(Request $request, $slug)
    {
        $request->validate([
            'password' => 'required|string'
        ]);

        $digitalCard = DigitalCard::where('slug', $slug)
            ->where('is_active', true)
            ->where('is_public', true)
            ->firstOrFail();

        if ($digitalCard->is_password_protected && $digitalCard->password !== $request->password) {
            return back()->withErrors(['password' => 'Invalid password.']);
        }

        // Store access in session
        session(["card_access_{$digitalCard->id}" => true]);

        return redirect()->route('digital-card.public', $slug);
    }

    /**
     * Track component click.
     */
    public function trackClick($slug, $componentId)
    {
        $digitalCard = DigitalCard::where('slug', $slug)
            ->where('is_active', true)
            ->where('is_public', true)
            ->firstOrFail();

        $component = CardComponent::where('id', $componentId)
            ->where('digital_card_id', $digitalCard->id)
            ->where('is_active', true)
            ->firstOrFail();

        // Track click analytics
        $this->trackClickAnalytics($digitalCard, $component);

        // Redirect to component URL or perform action based on type
        switch ($component->type) {
            case 'link':
                return redirect($component->content);
            case 'phone':
                return redirect("tel:{$component->content}");
            case 'email':
                return redirect("mailto:{$component->content}");
            case 'map':
                return redirect("https://maps.google.com/?q=" . urlencode($component->content));
            case 'social':
                return redirect($component->config['url'] ?? '#');
            default:
                return back();
        }
    }

    /**
     * Track view analytics.
     */
    private function trackView(DigitalCard $digitalCard)
    {
        if (!$digitalCard->enable_analytics) {
            return;
        }

        $agent = new Agent();
        
        CardAnalytics::create([
            'digital_card_id' => $digitalCard->id,
            'action' => 'view',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referrer' => request()->header('referer'),
            'country' => $this->getCountryFromIP(request()->ip()),
            'city' => null, // Could be enhanced with IP geolocation service
            'device_type' => $agent->isDesktop() ? 'desktop' : ($agent->isTablet() ? 'tablet' : 'mobile'),
            'browser' => $agent->browser(),
            'os' => $agent->platform(),
            'time_on_page' => 0,
            'load_time' => 0,
            'viewed_at' => now(),
        ]);

        // Increment view count
        $digitalCard->incrementViewCount();
    }

    /**
     * Track click analytics.
     */
    private function trackClickAnalytics(DigitalCard $digitalCard, CardComponent $component)
    {
        if (!$digitalCard->enable_analytics) {
            return;
        }

        $agent = new Agent();
        
        CardAnalytics::create([
            'digital_card_id' => $digitalCard->id,
            'card_component_id' => $component->id,
            'action' => 'click',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referrer' => request()->header('referer'),
            'country' => $this->getCountryFromIP(request()->ip()),
            'city' => null, // Could be enhanced with IP geolocation service
            'device_type' => $agent->isDesktop() ? 'desktop' : ($agent->isTablet() ? 'tablet' : 'mobile'),
            'browser' => $agent->browser(),
            'os' => $agent->platform(),
            'clicked_at' => now(),
        ]);

        // Increment click count for component
        $component->incrementClickCount();
    }

    /**
     * Get country from IP address (basic implementation).
     */
    private function getCountryFromIP($ip)
    {
        // This is a basic implementation
        // In production, you might want to use a service like MaxMind GeoIP2 or IP2Location
        
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            // For now, return null - you can implement actual IP geolocation here
            return null;
        }
        
        return null;
    }
}