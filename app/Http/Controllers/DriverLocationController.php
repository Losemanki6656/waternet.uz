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
        $user = auth()->user();

        $query = User::where('role', 3)
            ->where('status', true)
            ->whereNotNull('last_lat')
            ->with('organization:id,name');

        // Super-admin (id == 1) sees every driver across all organizations;
        // everyone else is scoped to their own organization.
        if ($user->id != 1 && $user->organization_id) {
            $query->where('organization_id', $user->organization_id);
        }

        $drivers = $query->get(['id', 'name', 'phone', 'organization_id', 'last_lat', 'last_lng', 'last_location_at']);

        $kmByUser = $this->kmTravelledToday($drivers->pluck('id'));

        $data = $drivers->map(function ($d) use ($kmByUser) {
            $online = $d->last_location_at && $d->last_location_at->gt(now()->subMinutes(2));

            return [
                'id' => $d->id,
                'name' => $d->name,
                'phone' => $d->phone,
                'organization' => optional($d->organization)->name,
                'lat' => (float) $d->last_lat,
                'lng' => (float) $d->last_lng,
                'last_location_at' => optional($d->last_location_at)->toDateTimeString(),
                'online' => $online,
                'km_today' => $kmByUser[$d->id] ?? 0,
            ];
        });

        return response()->json($data);
    }

    /**
     * Sum the distance (km) each driver travelled today from their recorded
     * track points (haversine between consecutive points).
     */
    private function kmTravelledToday($driverIds): array
    {
        if ($driverIds->isEmpty()) {
            return [];
        }

        $points = DriverLocation::whereIn('user_id', $driverIds)
            ->whereDate('recorded_at', today())
            ->orderBy('user_id')
            ->orderBy('recorded_at')
            ->get(['user_id', 'latitude', 'longitude']);

        $km = [];

        foreach ($points->groupBy('user_id') as $uid => $pts) {
            $total = 0.0;
            $prev = null;

            foreach ($pts as $p) {
                if ($prev) {
                    $total += $this->haversine($prev->latitude, $prev->longitude, $p->latitude, $p->longitude);
                }
                $prev = $p;
            }

            $km[$uid] = round($total, 1);
        }

        return $km;
    }

    private function haversine($lat1, $lon1, $lat2, $lon2): float
    {
        $earth = 6371; // km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) ** 2
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) ** 2;

        return $earth * 2 * atan2(sqrt($a), sqrt(1 - $a));
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
