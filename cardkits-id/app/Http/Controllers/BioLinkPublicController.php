<?php

namespace App\Http\Controllers;

use App\Models\BioLink;
use App\Models\BioLinkAnalytics;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class BioLinkPublicController extends Controller
{
    /**
     * Display the specified bio link publicly.
     */
    public function show($slug)
    {
        $bioLink = BioLink::where('slug', $slug)
            ->where('is_active', true)
            ->with(['items' => function($query) {
                $query->where('is_active', true)->orderBy('order');
            }, 'socialMedia' => function($query) {
                $query->where('is_active', true)->orderBy('order');
            }])
            ->firstOrFail();

        // Track view
        $this->trackView($bioLink);

        return view('bio-links.public', compact('bioLink'));
    }

    /**
     * Track a link click
     */
    public function trackClick(Request $request, $slug, $itemId)
    {
        $bioLink = BioLink::where('slug', $slug)->firstOrFail();
        $item = $bioLink->items()->findOrFail($itemId);

        // Track click
        $this->trackClickAnalytics($bioLink, $item);

        // Redirect to the actual URL
        return redirect($item->formatted_url);
    }

    /**
     * Track view analytics
     */
    private function trackView(BioLink $bioLink)
    {
        $agent = new Agent();
        
        BioLinkAnalytics::create([
            'bio_link_id' => $bioLink->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referrer' => request()->header('referer'),
            'device_type' => $agent->isMobile() ? 'mobile' : ($agent->isTablet() ? 'tablet' : 'desktop'),
            'browser' => $agent->browser(),
            'os' => $agent->platform(),
            'action' => 'view'
        ]);

        // Increment view count
        $bioLink->incrementViewCount();
    }

    /**
     * Track click analytics
     */
    private function trackClickAnalytics(BioLink $bioLink, $item)
    {
        $agent = new Agent();
        
        BioLinkAnalytics::create([
            'bio_link_id' => $bioLink->id,
            'bio_link_item_id' => $item->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referrer' => request()->header('referer'),
            'device_type' => $agent->isMobile() ? 'mobile' : ($agent->isTablet() ? 'tablet' : 'desktop'),
            'browser' => $agent->browser(),
            'os' => $agent->platform(),
            'action' => 'click',
            'clicked_at' => now()
        ]);

        // Increment click count
        $item->incrementClickCount();
    }
}
