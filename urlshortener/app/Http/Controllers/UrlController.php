<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;
use App\Models\UrlLog;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UrlController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'validity' => 'nullable|integer|min:1',
            'shortcode' => 'nullable|alpha_num|unique:urls,shortcode',
        ]);

        $shortcode = $request->shortcode ?? Str::random(6);
        $validity = $request->validity ?? 30;

        $expiry = Carbon::now()->addMinutes($validity);

        $url = Url::create([
            'original_url' => $request->url,
            'shortcode' => $shortcode,
            'expiry' => $expiry,
        ]);

        return response()->json([
            'shortLink' => url($shortcode),
            'expiry' => $expiry->toIso8601String(),
        ], 201);
    }

     public function redirect($shortcode, Request $request)
    {
        $url = Url::where('shortcode', $shortcode)->first();

        if (!$url) {
            return response()->json(['error' => 'Shortcode not found'], 404);
        }

        if (Carbon::now()->greaterThan($url->expiry)) {
            return response()->json(['error' => 'Link expired'], 410);
        }

        $url->increment('clicks');
        UrlLog::create([
            'url_id' => $url->id,
            'clicked_at' => now(),
            'referrer' => $request->headers->get('referer', 'direct'),
            'location' => $request->ip(), // can integrate geoIP later
        ]);

        return redirect($url->original_url);
    }
    public function stats($shortcode)
    {
        $url = Url::with('logs')->where('shortcode', $shortcode)->first();

        if (!$url) {
            return response()->json(['error' => 'Shortcode not found'], 404);
        }

        return response()->json([
            'originalUrl' => $url->original_url,
            'createdAt' => $url->created_at,
            'expiry' => $url->expiry,
            'clicks' => $url->clicks,
            'logs' => $url->logs->map(function ($log) {
                return [
                    'timestamp' => $log->clicked_at,
                    'referrer' => $log->referrer,
                    'location' => $log->location
                ];
            })
        ]);
    }
}
