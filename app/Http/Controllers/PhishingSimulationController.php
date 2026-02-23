<?php

namespace App\Http\Controllers;

use App\Models\PhishingLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PhishingSimulationController extends Controller
{
    /**
     * Show the phishing simulation landing page.
     * Called when the target clicks the link in their email.
     */
    public function show(Request $request): \Illuminate\View\View
{
    PhishingLog::create([
        'ip_address'  => $request->ip(),
        'user_agent'  => $request->userAgent(),
        'captured_at' => now(),
    ]); 
    return view('phishing-simulation');
}

    /**
     * Store the captured data submitted from the form.
     * Records: email, IP address, timestamp, and geolocation.
     */
    public function capture(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email'          => ['required', 'email', 'max:255'],
            'latitude'       => ['nullable', 'numeric', 'between:-90,90'],
            'longitude'      => ['nullable', 'numeric', 'between:-180,180'],
            'location_label' => ['nullable', 'string', 'max:255'],
        ]);

        // Get real IP, accounting for proxies/load balancers
        $ip = $request->header('X-Forwarded-For')
            ?? $request->header('X-Real-IP')
            ?? $request->ip();

        // If X-Forwarded-For has multiple IPs, take the first (client IP)
        if (str_contains($ip, ',')) {
            $ip = trim(explode(',', $ip)[0]);
        }

        PhishingLog::create([
            'email'          => $validated['email'],
            'ip_address'     => $ip,
            'latitude'       => $validated['latitude']  ?? null,
            'longitude'      => $validated['longitude'] ?? null,
            'location_label' => $validated['location_label'] ?? 'Not available',
            'user_agent'     => $request->userAgent(),
            'captured_at'    => now(),
        ]);

        return response()->json(['success' => true]);
    }
}