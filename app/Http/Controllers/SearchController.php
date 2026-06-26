<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    /**
     * AJAX search for dropdown results
     */
    public function index(Request $request)
    {
        $query = Str::lower($request->get('q', ''));
        
        if (strlen($query) < 2) {
            return response()->json([
                'routes' => [],
                'vehicles' => [],
                'drivers' => [],
                'partners' => [],
            ]);
        }

        $like = '%' . $query . '%';

        // Search routes
        $routes = Route::where('is_active', true)
            ->where(function ($q) use ($like) {
                $q->whereRaw('LOWER(name) LIKE ?', [$like])
                  ->orWhereRaw('LOWER(origin_city) LIKE ?', [$like])
                  ->orWhereRaw('LOWER(destination_city) LIKE ?', [$like]);
            })
            ->limit(5)
            ->get()
            ->map(fn($r) => [
                'id' => $r->id,
                'label' => ($r->origin_city ?? '') . ' → ' . ($r->destination_city ?? ''),
                'sub' => $r->name ?? 'Route',
                'url' => route('bookings.travel'),
                'type' => 'route',
            ]);

        // Search vehicles
        $vehicles = Vehicle::where(function ($q) use ($like) {
                $q->whereRaw('LOWER(plate_number) LIKE ?', [$like])
                  ->orWhereRaw('LOWER(brand) LIKE ?', [$like])
                  ->orWhereRaw('LOWER(model) LIKE ?', [$like]);
            })
            ->limit(5)
            ->get()
            ->map(fn($v) => [
                'id' => $v->id,
                'label' => ($v->brand ?? '') . ' ' . ($v->model ?? ''),
                'sub' => $v->plate_number ?? '',
                'url' => route('vehicles.show', $v->id),
                'type' => 'vehicle',
            ]);

        // Search drivers
        $drivers = Driver::with('user')
            ->where(function ($q) use ($like) {
                $q->whereRaw('LOWER(phone) LIKE ?', [$like])
                  ->orWhereHas('user', fn($uq) => $uq->whereRaw('LOWER(name) LIKE ?', [$like]));
            })
            ->limit(5)
            ->get()
            ->map(fn($d) => [
                'id' => $d->id,
                'label' => $d->user->name ?? 'Driver',
                'sub' => $d->phone ?? '',
                'url' => route('drivers.show', $d->id),
                'type' => 'driver',
            ]);

        // Search partners
        $partners = Mitra::where(function ($q) use ($like) {
                $q->whereRaw('LOWER(name) LIKE ?', [$like])
                  ->orWhereRaw('LOWER(email) LIKE ?', [$like]);
            })
            ->limit(5)
            ->get()
            ->map(fn($p) => [
                'id' => $p->id,
                'label' => $p->name ?? 'Partner',
                'sub' => $p->email ?? '',
                'url' => route('partners.show', $p->id),
                'type' => 'partner',
            ]);

        return response()->json([
            'routes' => $routes,
            'vehicles' => $vehicles,
            'drivers' => $drivers,
            'partners' => $partners,
        ]);
    }

    /**
     * Full search results page
     */
    public function show(Request $request)
    {
        $query = Str::lower($request->get('q', ''));
        $results = collect();

        if (strlen($query) >= 2) {
            $like = '%' . $query . '%';

            // Search routes
            $routes = Route::where('is_active', true)
                ->where(function ($q) use ($like) {
                    $q->whereRaw('LOWER(name) LIKE ?', [$like])
                      ->orWhereRaw('LOWER(origin_city) LIKE ?', [$like])
                      ->orWhereRaw('LOWER(destination_city) LIKE ?', [$like]);
                })
                ->limit(10)
                ->get()
                ->map(fn($r) => [
                    'title' => ($r->origin_city ?? '') . ' → ' . ($r->destination_city ?? ''),
                    'subtitle' => $r->name ?? 'Route',
                    'url' => route('bookings.travel'),
                    'badge' => 'Route',
                    'badge_color' => 'blue',
                ]);

            // Search vehicles
            $vehicles = Vehicle::where(function ($q) use ($like) {
                    $q->whereRaw('LOWER(plate_number) LIKE ?', [$like])
                      ->orWhereRaw('LOWER(brand) LIKE ?', [$like])
                      ->orWhereRaw('LOWER(model) LIKE ?', [$like]);
                })
                ->limit(10)
                ->get()
                ->map(fn($v) => [
                    'title' => ($v->brand ?? '') . ' ' . ($v->model ?? ''),
                    'subtitle' => 'Plate: ' . ($v->plate_number ?? ''),
                    'url' => route('vehicles.show', $v->id),
                    'badge' => 'Vehicle',
                    'badge_color' => 'green',
                ]);

            // Search drivers
            $drivers = Driver::with('user')
                ->where(function ($q) use ($like) {
                    $q->whereRaw('LOWER(phone) LIKE ?', [$like])
                      ->orWhereHas('user', fn($uq) => $uq->whereRaw('LOWER(name) LIKE ?', [$like]));
                })
                ->limit(10)
                ->get()
                ->map(fn($d) => [
                    'title' => $d->user->name ?? 'Driver',
                    'subtitle' => 'Phone: ' . ($d->phone ?? ''),
                    'url' => route('drivers.show', $d->id),
                    'badge' => 'Driver',
                    'badge_color' => 'purple',
                ]);

            // Search partners
            $partners = Mitra::where(function ($q) use ($like) {
                    $q->whereRaw('LOWER(name) LIKE ?', [$like])
                      ->orWhereRaw('LOWER(email) LIKE ?', [$like]);
                })
                ->limit(10)
                ->get()
                ->map(fn($p) => [
                    'title' => $p->name ?? 'Partner',
                    'subtitle' => 'Email: ' . ($p->email ?? ''),
                    'url' => route('partners.show', $p->id),
                    'badge' => 'Partner',
                    'badge_color' => 'orange',
                ]);

            $results = $routes->merge($vehicles)->merge($drivers)->merge($partners);
        }

        return view('search.results', compact('results', 'query'));
    }
}
