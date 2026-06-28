<?php

namespace App\Http\Controllers;

use App\Models\DriverLocation;
use App\Models\User;
use Illuminate\Http\Request;

class DriverLocationController extends Controller
{
    /**
     * Driver app (JWT) — receive a batch of GPS points.
     * Body: { "locations": [ { lat, lng, recorded_at, accuracy?, speed?, heading? }, ... ] }
     * A single { lat, lng, ... } body is also accepted.
     */
    public function store(Request $request)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $points = $request->input('locations', []);

        if (empty($points) && $request->filled('lat')) {
            $points = [$request->only(['lat', 'lng', 'accuracy', 'speed', 'heading', 'recorded_at'])];
        }

        if (empty($points)) {
            return response()->json(['message' => 'no points', 'saved' => 0]);
        }

        $now = now();
        $rows = [];
        $latest = null;

        foreach ($points as $p) {
            $lat = $p['lat'] ?? ($p['latitude'] ?? null);
            $lng = $p['lng'] ?? ($p['longitude'] ?? null);

            if ($lat === null || $lng === null || !is_numeric($lat) || !is_numeric($lng)) {
                continue;
            }

            $recordedAt = $this->parseTime($p['recorded_at'] ?? null, $now);

            $rows[] = [
                'user_id' => $user->id,
                'organization_id' => $user->organization_id,
                'latitude' => $lat,
                'longitude' => $lng,
                'accuracy' => $p['accuracy'] ?? null,
                'speed' => $p['speed'] ?? null,
                'heading' => $p['heading'] ?? null,
                'recorded_at' => $recordedAt,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            if ($latest === null || $recordedAt >= $latest['recorded_at']) {
                $latest = ['lat' => $lat, 'lng' => $lng, 'recorded_at' => $recordedAt];
            }
        }

        if (empty($rows)) {
            return response()->json(['message' => 'no valid points', 'saved' => 0]);
        }

        DriverLocation::insert($rows);

        if ($latest) {
            $user->last_lat = $latest['lat'];
            $user->last_lng = $latest['lng'];
            $user->last_location_at = $latest['recorded_at'];
            $user->save();
        }

        return response()->json(['message' => 'success', 'saved' => count($rows)]);
    }

    /**
     * Admin (session) — the live drivers map page.
     */
    public function map()
    {
        return view('drivers.map');
    }

    /**
     * Admin (session) — JSON of every driver's last known position
     * within the current organization, with an online flag.
     */
    public function locations()
    {
        $orgId = auth()->user()->organization_id;

        $drivers = User::where('organization_id', $orgId)
            ->where('role', 3)
            ->where('status', true)
            ->whereNotNull('last_lat')
            ->get(['id', 'name', 'phone', 'last_lat', 'last_lng', 'last_location_at']);

        $data = $drivers->map(function ($d) {
            $online = $d->last_location_at && $d->last_location_at->gt(now()->subMinutes(2));

            return [
                'id' => $d->id,
                'name' => $d->name,
                'phone' => $d->phone,
                'lat' => (float) $d->last_lat,
                'lng' => (float) $d->last_lng,
                'last_location_at' => optional($d->last_location_at)->toDateTimeString(),
                'online' => $online,
            ];
        });

        return response()->json($data);
    }

    private function parseTime($value, $fallback)
    {
        if (empty($value)) {
            return $fallback;
        }

        // background-geolocation gives epoch milliseconds
        if (is_numeric($value)) {
            return date('Y-m-d H:i:s', (int) ($value / 1000));
        }

        $ts = strtotime($value);

        return $ts ? date('Y-m-d H:i:s', $ts) : $fallback;
    }
}
