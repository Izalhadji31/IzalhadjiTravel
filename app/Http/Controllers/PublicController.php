<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\RentalPrice;
use App\Models\TravelPrice;
use App\Models\Setting;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PublicController extends Controller
{
    /**
     * Show public landing page
     */
    public function home()
    {
        $travelRoutes = Schema::hasTable('routes')
            ? Route::active()->travel()->with('travelPrices')->take(6)->get()
            : collect();
        $rentalServices = Schema::hasTable('rental_prices')
            ? RentalPrice::active()->with('route')->take(6)->get()
            : collect();

        return view('public.home', compact('travelRoutes', 'rentalServices'));
    }

    /**
     * Show all travel routes publicly
     */
    public function travelList(Request $request)
    {
        $query = Route::active()->travel()->with(['travelPrices']);

        // Filter by origin
        if ($request->filled('origin')) {
            $query->where('origin_city', $request->origin);
        }

        // Filter by destination
        if ($request->filled('destination')) {
            $query->where('destination_city', $request->destination);
        }

        // Filter by price range
        if ($request->filled('price_min') && $request->filled('price_max')) {
            $query->whereHas('travelPrices', function ($q) use ($request) {
                $q->whereBetween('price', [$request->price_min, $request->price_max]);
            });
        }

        // Sort
        $sortBy = $request->get('sort', 'destination_city');
        if (in_array($sortBy, ['destination_city', 'distance_km', 'created_at'])) {
            $query->orderBy($sortBy, $request->get('order', 'asc'));
        }

        $routes = $query->paginate(12);
        $origins = Route::active()->travel()->distinct()->pluck('origin_city');
        $destinations = Route::active()->travel()->distinct()->pluck('destination_city');

        return view('public.travel', compact('routes', 'origins', 'destinations'));
    }

    /**
     * Show all rental services publicly
     */
    public function rentalList(Request $request)
    {
        $query = \App\Models\Armada::available()->with('mitra');

        if ($request->filled('vehicle_type')) {
            $query->where('vehicle_type', $request->vehicle_type);
        }

        if ($request->filled('min_capacity')) {
            $query->where('seat_capacity', '>=', $request->min_capacity);
        }

        $sortBy = $request->get('sort', 'vehicle_type');
        if (in_array($sortBy, ['vehicle_type', 'seat_capacity', 'created_at'])) {
            $query->orderBy($sortBy, $request->get('order', 'asc'));
        }

        $vehicles = $query->paginate(12);
        $vehicleTypes = \App\Models\Armada::available()->distinct()->pluck('vehicle_type')->filter();

        return view('public.rental', compact('vehicles', 'vehicleTypes'));
    }

    /**
     * Show price calculator
     */
    public function priceCalculator()
    {
        $routes = Route::active()->get();

        return view('public.price-calculator', compact('routes'));
    }

    /**
     * Calculate price via AJAX
     */
    public function calculatePrice(Request $request)
    {
        $validated = $request->validate([
            'service' => 'required|in:travel,rental',
            'route_id' => 'nullable|exists:routes,id',
            'destination' => 'nullable|string',
            'vehicle_type' => 'nullable|string',
            'with_driver' => 'nullable|boolean',
            'days' => 'nullable|integer|min:1',
        ]);

        $price = 0;

        if ($validated['service'] === 'travel' && $validated['route_id']) {
            $travelPrice = TravelPrice::where('route_id', $validated['route_id'])->first();
            if ($travelPrice) {
                $price = $travelPrice->price_per_seat;
            }
        } elseif ($validated['service'] === 'rental' && $validated['destination']) {
            $rentalPrice = RentalPrice::whereHas('route', fn($q) => $q->where('destination_city', $validated['destination']))
                ->first();

            if ($rentalPrice) {
                $withDriver = $validated['with_driver'] ?? false;
                $days = $validated['days'] ?? 1;
                $dailyPrice = $withDriver ? $rentalPrice->price_with_driver : $rentalPrice->price_without_driver;
                $price = $dailyPrice * $days;
            }
        }

        return response()->json([
            'success' => true,
            'price' => $price,
            'formatted_price' => 'Rp ' . number_format($price, 0, ',', '.'),
        ]);
    }

    /**
     * Show about page
     */
    public function about()
    {
        return view('public.about');
    }

    /**
     * Show contact page
     */
    public function contact()
    {
        return view('public.contact');
    }

    /**
     * Handle contact form submission
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        // Save to database or send email
        // For now, just redirect
        return redirect()
            ->route('public.contact')
            ->with('success', 'Terima kasih! Pesan Anda telah dikirim. Kami akan menghubungi Anda segera.');
    }

    /**
     * Show all available vehicles for rental
     */
    public function vehiclesList(Request $request)
    {
        $query = \App\Models\Armada::available()->with('mitra');

        // Filter by vehicle type
        if ($request->filled('vehicle_type')) {
            $query->where('vehicle_type', $request->vehicle_type);
        }

        // Filter by seat capacity
        if ($request->filled('min_capacity')) {
            $query->where('seat_capacity', '>=', $request->min_capacity);
        }

        // Sort
        $sortBy = $request->get('sort', 'vehicle_type');
        if (in_array($sortBy, ['vehicle_type', 'seat_capacity', 'created_at'])) {
            $query->orderBy($sortBy, $request->get('order', 'asc'));
        }

        $vehicles = $query->paginate(12);
        $vehicleTypes = \App\Models\Armada::available()->distinct()->pluck('vehicle_type');

        return view('public.vehicles', compact('vehicles', 'vehicleTypes'));
    }

    /**
     * Show all blog/articles
     */
    public function blog()
    {
        $articles = \App\Models\CmsPage::where('is_published', true)
            ->whereIn('type', ['blog', 'page'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('public.blog', compact('articles'));
    }

    /**
     * Show single blog/article detail
     */
    public function blogDetail($slug)
    {
        $article = \App\Models\CmsPage::where('slug', $slug)
            ->where('is_published', true)
            ->whereIn('type', ['blog', 'page'])
            ->firstOrFail();

        return view('public.blog-detail', compact('article'));
    }

    /**
     * Show a public CMS page by slug
     */
    public function showPage($slug)
    {
        $page = \App\Models\CmsPage::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return view('public.page', compact('page'));
    }

    /**
     * Subscribe to newsletter
     */
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:newsletters,email',
            'name' => 'nullable|string|max:255',
        ]);

        Newsletter::create($validated);

        return back()->with('success', 'Terima kasih! Anda berhasil berlangganan newsletter kami.');
    }

    /**
     * Destinasi Wisata Flores Page
     */
    public function destinasi()
    {
        return view('public.destinasi');
    }


    public function testimoni()
    {
        return view('public.testimoni');
    }

    public function faq()
    {
        return view('public.faq');
    }

    public function syaratKetentuan()
    {
        return view('public.syarat-ketentuan');
    }

    public function kebijakanPrivasi()
    {
        return view('public.kebijakan-privasi');
    }

    public function cekBooking()
    {
        return view('public.cek-booking');
    }

    public function destinasiDetail($slug)
    {
        $destinations = $this->getDestinations();
        $destination = $destinations[$slug] ?? null;
        
        if (!$destination) {
            abort(404);
        }
        
        // Get nearby destinations from same region
        $nearby = [];
        foreach ($destinations as $key => $d) {
            if ($key !== $slug && ($d['region'] ?? '') === ($destination['region'] ?? '')) {
                $nearby[] = array_merge($d, ['slug' => $key]);
            }
        }
        
        return view('public.destinasi-detail', compact('destination', 'nearby'));
    }

    private function getDestinations(): array
    {
        return [
            'danau-kelimutu' => [
                'name' => 'Danau Kelimutu',
                'region' => 'Ende',
                'slug' => 'danau-kelimutu',
                'image' => 'https://images.unsplash.com/photo-1609137144813-7d9921338f24?w=1400&q=80',
                'short_desc' => 'Tiga danau kawah dengan warna berbeda yang berubah secara misterius selama bertahun-tahun.',
                'full_desc' => '<p>Danau Kelimutu terletak di puncak Gunung Kelimutu, Kabupaten Ende, Nusa Tenggara Timur. Terdapat tiga danau kawah yang masing-masing memiliki warna berbeda:</p><ul><li><strong>Tiwu Ata Mbupu</strong> (Danau Lanjut Usia) - warna biru</li><li><strong>Tiwu Nuwa Muri Koo Fai</strong> (Danau Pemuda dan Gadis) - warna hijau</li><li><strong>Tiwu Ata Polo</strong> (Danau Bercinta) - warna merah</li></ul><p>Ketiga danau ini dipercaya oleh suku Lio sebagai tempat bersemangnya arwah orang yang telah meninggal. Warna-warna danau ini telah berubah beberapa kali dalam 40 tahun terakhir.</p>',
                'price_start' => 200000,
                'gallery' => [
                    'https://images.unsplash.com/photo-1609137144813-7d9921338f24?w=800&q=80',
                    'https://images.unsplash.com/photo-1559128010-7c1ad6e1b6a5?w=800&q=80',
                    'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=800&q=80',
                    'https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=800&q=80',
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Puncak Gunung Kelimutu'],
                    ['icon' => '📍', 'label' => 'Jarak dari Ende', 'value' => '51 km'],
                    ['icon' => '⏰', 'label' => 'Best Time', 'value' => 'Sunrise (05:30)'],
                    ['icon' => '🎫', 'label' => 'Tiket Masuk', 'value' => 'Rp 35.000'],
                    ['icon' => '⏱️', 'label' => 'Durasi Kunjungan', 'value' => '2-3 jam'],
                    ['icon' => '🏔️', 'label' => 'Ketinggian', 'value' => '1.639 mdpl'],
                ],
                'highlights' => [
                    'Sunrise spektakuler di puncak',
                    'Tiga danau warna-warni',
                    'Kawasan taman nasional',
                    'Warisan geologi dunia',
                    'Spot foto Instagram-worthy',
                    'Mitos dan spiritual suku Lio',
                ],
            ],
            'rumah-bung-karno' => [
                'name' => 'Rumah Bung Karno',
                'region' => 'Ende',
                'slug' => 'rumah-bung-karno',
                'image' => 'https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=1400&q=80',
                'short_desc' => 'Rumah tempat Bung Karno Ir. Soekarno diasingkan tahun 1934-1938. Disini lahir konsep Pancasila.',
                'full_desc' => '<p>Sebelum menjadi Presiden RI, Ir. Soekarno diasingkan oleh pemerintah Belanda ke Ende, Flores (1934-1938). Rumah tempat tinggalnya kini menjadi museum dan cagar budaya.</p><p>Di sinilah Bung Karno banyak merenung dan merumuskan dasar negara Indonesia yang kemudian dinamakan Pancasila. Rumah panggung bersejarah ini menyimpan benda-benda bersejarah termasuk meja tulis dan kursi serta koleksi foto-foto tempo dulu.</p><p>Rumah ini terletak di pusat kota Ende, hanya beberapa menit dari pantai. Di halaman rumah terdapat pohon beringin besar yang dipercaya pernah digunakan Bung Karno untuk berpidato.</p>',
                'price_start' => 50000,
                'gallery' => [
                    'https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=800&q=80',
                    'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=800&q=80',
                    'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800&q=80',
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Pusat Kota Ende'],
                    ['icon' => '📍', 'label' => 'Jarak dari pusat', 'value' => '2 km'],
                    ['icon' => '🕐', 'label' => 'Jam Buka', 'value' => '08:00 - 16:00'],
                    ['icon' => '🎫', 'label' => 'Tiket Masuk', 'value' => 'Rp 10.000'],
                    ['icon' => '📚', 'label' => 'Kategori', 'value' => 'Situs Sejarah'],
                    ['icon' => '✅', 'label' => 'Cocok untuk', 'value' => 'Semua usia'],
                ],
                'highlights' => [
                    'Rumah panggung bersejarah 1930an',
                    'Objek wisata edukasi',
                    'Koleksi foto Bung Karno',
                    'Pohon beringin tempat berpidato',
                    'Museum mini gratis',
                    'Spot foto vintage',
                ],
            ],
            'pulau-komodo' => [
                'name' => 'Pulau Komodo',
                'region' => 'Labuan Bajo',
                'slug' => 'pulau-komodo',
                'image' => 'https://images.unsplash.com/photo-1570789210967-2cac24afeb00?w=1400&q=80',
                'short_desc' => 'Habitat asli komodo (Varanus komodoensis), kadal terbesar di dunia. Warisan Alam UNESCO.',
                'full_desc' => '<p>Pulau Komodo adalah salah satu dari 76 pulau di Taman Nasional Komodo yang ditetapkan sebagai Warisan Alam Dunia UNESCO pada tahun 1991. Pulau ini adalah habitat asli komodo (Varanus komodoensis) dengan populasi sekitar 3.000 ekor.</p><p>Anda bisa trekking bersama ranger untuk melihat komodo di alam liar mereka. Trek wisata tersedia dalam beberapa pilihan rute (short, medium, long) dengan durasi 1-3 jam. Anda juga akan menemui satwa lain seperti rusa, kerbau liar, dan burung.</p>',
                'price_start' => 500000,
                'gallery' => [
                    'https://images.unsplash.com/photo-1570789210967-2cac24afeb00?w=800&q=80',
                    'https://images.unsplash.com/photo-1559128010-7c1ad6e1b6a5?w=800&q=80',
                    'https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?w=800&q=80',
                    'https://images.unsplash.com/photo-1546026423-cc4642628d2b?w=800&q=80',
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Taman Nasional Komodo'],
                    ['icon' => '📍', 'label' => 'Jarak dari Ende', 'value' => '247 km'],
                    ['icon' => '🕐', 'label' => 'Best Time', 'value' => '07:00 - 10:00'],
                    ['icon' => '🎫', 'label' => 'Retribusi', 'value' => 'Rp 250.000'],
                    ['icon' => '🐉', 'label' => 'Populasi', 'value' => '~3.000 komodo'],
                    ['icon' => '🏆', 'label' => 'Status', 'value' => 'UNESCO WHS'],
                ],
                'highlights' => [
                    'Trekking lihat komodo liar',
                    'Ranger berpengalaman',
                    'Spot foto legendaris',
                    'Taman Nasional UNESCO',
                    'Satwa endemik lainnya',
                    'Pemandangan savana + laut',
                ],
            ],
            'pink-beach' => [
                'name' => 'Pink Beach',
                'region' => 'Labuan Bajo',
                'slug' => 'pink-beach',
                'image' => 'https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?w=1400&q=80',
                'short_desc' => 'Salah satu dari 7 pantai berpasir merah muda di dunia. Keindahan bawah lautnya luar biasa.',
                'full_desc' => '<p>Pink Beach (Pantai Merah) adalah salah satu dari hanya tujuh pantai berpasir pink di dunia. Warna pink berasal dari campuran pasir putih dengan fragmen karang merah (foraminifera) yang dihancurkan ombak selama ribuan tahun.</p><p>Pantai ini menawarkan snorkeling kelas dunie dengan air super jernih dan biota laut yang berwarna-warni. Anda juga bisa hanya berenang, berjemur, atau dilihat dari bukit untuk panorama terbaik.</p>',
                'price_start' => 300000,
                'gallery' => [
                    'https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?w=800&q=80',
                    'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800&q=80',
                    'https://images.unsplash.com/photo-1546026423-cc4642628d2b?w=800&q=80',
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Labuan Bajo, Manggarai Barat'],
                    ['icon' => '📍', 'label' => 'Jarak dari Ende', 'value' => '247 km'],
                    ['icon' => '🕐', 'label' => 'Best Time', 'value' => 'Pagi-Malam'],
                    ['icon' => '🎫', 'label' => 'Retribusi', 'value' => 'Rp 50.000'],
                    ['icon' => '🏖️', 'label' => 'Warna Pasir', 'value' => 'Pink/Merah Muda'],
                    ['icon' => '🤿', 'label' => 'Snorkeling', 'value' => 'Excellent'],
                ],
                'highlights' => [
                    'Satu dari 7 pantai pink di dunia',
                    'Snorkeling dengan visibilitas 30m+',
                    'Warna pasir unik',
                    'Instagram sensation',
                    'Boat trip dari Labuan Bajo',
                    'Sunset yang memukau',
                ],
            ],
            'wae-rebo' => [
                'name' => 'Desa Wae Rebo',
                'region' => 'Ruteng',
                'slug' => 'wae-rebo',
                'image' => 'https://images.unsplash.com/photo-1528181304800-259b08848526?w=1400&q=80',
                'short_desc' => 'Desa tradisional Manggarai di atas awan 1.200 mdpl dengan rumah kerucut unik. Penghargaan UNESCO.',
                'full_desc' => '<p>Desa Wae Rebo adalah permukiman tradisional terpencil di ketinggian 1.200 mdpl di Manggarai, Flores. Desa ini terkenal dengan rumah adat berbentuk kerucut yang disebut "Mbaru Niang" dan mendapat Penghargaan Konservasi Warisan Budaya UNESCO Asia-Pasifik pada tahun 2012.</p><p>Untuk mencapai desa ini, Anda harus trekking 4.5 km (sekitar 4-5 jam) dari jalan terdekat melewati hujan tropis yang lebat. Tapi semua lelah akan terbayar saat tiba di desa dengan 7 rumah kerucut kuno, ditemani pemandangan awan yang menakjubkan dan keramahan suku Manggarai.</p>',
                'price_start' => 350000,
                'gallery' => [
                    'https://images.unsplash.com/photo-1528181304800-259b08848526?w=800&q=80',
                    'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=800&q=80',
                    'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=800&q=80',
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Kec. Satar Mese, Manggarai'],
                    ['icon' => '📍', 'label' => 'Jarak dari Ruteng', 'value' => '35 km'],
                    ['icon' => '🕐', 'label' => 'Best Time', 'value' => 'Mei-Oktober'],
                    ['icon' => '🎫', 'label' => 'Retribusi', 'value' => 'Rp 300.000'],
                    ['icon' => '🏔️', 'label' => 'Ketinggian', 'value' => '1.200 mdpl'],
                    ['icon' => '🚶', 'label' => 'Trekking', 'value' => '4-5 jam'],
                ],
                'highlights' => [
                    '7 rumah Mbaru Niang kuno',
                    'Penghargaan UNESCO 2012',
                    'Trekking hutan tropis',
                    'Pengalaman menginap di rumah adat',
                    'Melihat sunrise di atas awan',
                    'Budaya Manggarai autentik',
                ],
            ],
            'kampung-bena' => [
                'name' => 'Kampung Bena',
                'region' => 'Bajawa',
                'slug' => 'kampung-bena',
                'image' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=1400&q=80',
                'short_desc' => 'Desa adat Ngada dengan megalit kuno dan rumah tradisional. Warisan budaya yang dilestarikan.',
                'full_desc' => '<p>Kampung Bena adalah salah satu desa adat Ngada yang paling terkenal, terletak di lereng Gunung Inerie, Kabupaten Ngada. Desa ini memiliki susunan rumah tradisional yang tersusun rata dengan batu-batu megalitik dan altar pemujaan.</p><p>Terdapat 9 suku (kampung) yang tersebar di sekitar Bukit Bena. Anda bisa melihat pakaian tenun ikat asli Ngada, mengunjungi makam batu megalitikum, dan menikmati pemandangan Gunung Inerie dan Bajawa yang hijau. Tiap suku memiliki rumah induk bernama Sa\'o dan panggung pemujaan bernama Nabe.</p>',
                'price_start' => 150000,
                'gallery' => [
                    'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=800&q=80',
                    'https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=800&q=80',
                    'https://images.unsplash.com/photo-1432405972618-c6b0cfba8b03?w=800&q=80',
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Bajawa, Kabupaten Ngada'],
                    ['icon' => '📍', 'label' => 'Jarak dari Ende', 'value' => '85 km'],
                    ['icon' => '🕐', 'label' => 'Best Time', 'value' => 'Pagi hari'],
                    ['icon' => '🎫', 'label' => 'Retribusi', 'value' => 'Rp 20.000'],
                    ['icon' => '⛰️', 'label' => 'Latar', 'value' => 'Gunung Inerie'],
                    ['icon' => '📜', 'label' => 'Kategori', 'value' => 'Cagar Budaya'],
                ],
                'highlights' => [
                    '9 rumah tradisional Ngada',
                    'Megalitikum kuno 500+ tahun',
                    'Latar Gunung Inerie ikonik',
                    'Pakaian tenun ikat asli',
                    'Pola pemukiman tradisional',
                    'Spot foto sunrise/sunset',
                ],
            ],
            'teluk-maumere' => [
                'name' => 'Teluk Maumere',
                'region' => 'Maumere',
                'slug' => 'teluk-maumere',
                'image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=1400&q=80',
                'short_desc' => 'Surga diving dan snorkeling dengan keanekaragaman biota laut tertinggi di Indonesia Timur.',
                'full_desc' => '<p>Teluk Maumere, Sikka, Flores, diakui oleh Conservation International sebagai salah satu lokasi penyelaman terbaik di dunia. Di dalam teluk ini terdapat 30+ spot diving dengan biodiversitas laut tertinggi di Sabuk Coral (Coral Triangle).</p><p>Spesies ikan yang bisa Anda temui termasuk hiu paus, manta pari, penyu, napoleon wrasse, dan ikan-ikan karang warna-warni. Selama Perang Dunia II, kapal-kapal karam (Rusia, Jepang, AS) kini menjadi terumbu karang buatan yang indah.</p>',
                'price_start' => 200000,
                'gallery' => [
                    'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800&q=80',
                    'https://images.unsplash.com/photo-1546026423-cc4642628d2b?w=800&q=80',
                    'https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?w=800&q=80',
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Teluk Maumere, Sikka'],
                    ['icon' => '📍', 'label' => 'Jarak dari Ende', 'value' => '148 km'],
                    ['icon' => '🕐', 'label' => 'Best Time', 'value' => 'April-November'],
                    ['icon' => '🎫', 'label' => 'Diving', 'value' => 'Rp 300.000'],
                    ['icon' => '🐠', 'label' => 'Biodiversitas', 'value' => 'Tertinggi di Coral Triangle'],
                    ['icon' => '🤿', 'label' => 'Spot Dive', 'value' => '30+ lokasi'],
                ],
                'highlights' => [
                    'Salah satu lokasi diving terbaik dunia',
                    'Shipwreck WW II',
                    'Hiu paus di musimnya',
                    'Biota laut super warna',
                    'Coral Triangle Centre',
                    'Snorkeling kelas dunia',
                ],
            ],
            'taman-laut-17-pulau' => [
                'name' => 'Taman Laut 17 Pulau',
                'region' => 'Riung',
                'slug' => 'taman-laut-17-pulau',
                'image' => 'https://images.unsplash.com/photo-1546026423-cc4642628d2b?w=1400&q=80',
                'short_desc' => '17 pulau kecil dengan ekosistem terumbu karang terjaga dan populasi kelelawar raksasa.',
                'full_desc' => '<p>Taman Laut 17 Pulau adalah kawasan konservasi laut di Teluk Riung, Nagekeo, Flores. Kawasan ini terdiri dari 17 pulau kecil yang tersebar di teluk dengan ekosistem terumbu karang yang masih sangat alami.</p><p>Destinasi uniknya adalah melihat kelelawar raksasa (kalong) di Pulau Ontoloe. Setiap hari ratusan terbang ke tiga pulau buah untuk mencari makan - pemandangan yang mengesankan. Di pulau-pulau lain seperti Pulau Rutong dan Pulau Towa Andu, Anda bisa snorkeling dan berenang di pantai pasir putih.</p>',
                'price_start' => 200000,
                'gallery' => [
                    'https://images.unsplash.com/photo-1546026423-cc4642628d2b?w=800&q=80',
                    'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800&q=80',
                    'https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?w=800&q=80',
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Teluk Riung, Nagekeo'],
                    ['icon' => '📍', 'label' => 'Jarak dari Ende', 'value' => '125 km'],
                    ['icon' => '🕐', 'label' => 'Best Time', 'value' => '08:00 - 10:00'],
                    ['icon' => '🎫', 'label' => 'Retribusi', 'value' => 'Rp 50.000'],
                    ['icon' => '🦇', 'label' => 'Satwa', 'text' => '', 'value' => 'Kelelawar Raksasa'],
                    ['icon' => '🏝️', 'label' => 'Jumlah', 'value' => '17 pulau'],
                ],
                'highlights' => [
                    'Pulau kecil alami 17 buah',
                    'Kelelawar raksasa (Pulau Ontoloe)',
                    'Snorkeling terumbu karang',
                    'Pantai pasir putih',
                    'Boat trip antar pulau',
                    'Sunset pantai Riung',
                ],
            ],
            'pulau-padar' => [
                'name' => 'Pulau Padar',
                'region' => 'Labuan Bajo',
                'slug' => 'pulau-padar',
                'image' => 'https://images.unsplash.com/photo-1559128010-7c1ad6e1b6a5?w=1400&q=80',
                'short_desc' => 'Bukit berundak dengan panorama tiga teluk berbeda warna. Spot foto paling ikonik di Flores.',
                'full_desc' => '<p>Pulau Padar adalah pulau ketiga terbesar di Taman Nasional Komodo. Pulau ini terkenal dengan bukitnya yang berundak-undak dan bisa di-climb untuk mendapatkan panorama tiga teluk dan pantai yang berbeda warna.</p><p>Hiking ke puncak Padar membutuhkan waktu sekitar 30-45 menit dengan medan yang cukup curam. Tapi sesampainya di puncak, Anda akan disuguhi pemandangan tiga pantai (satu putih, satu pink, satu hitam) yang membentang di pulau-pulau sekitar. Salah satu foto yang paling dicari wisatawan mancanegara!</p>',
                'price_start' => 400000,
                'gallery' => [
                    'https://images.unsplash.com/photo-1559128010-7c1ad6e1b6a5?w=800&q=80',
                    'https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?w=800&q=80',
                    'https://images.unsplash.com/photo-1570789210967-2cac24afeb00?w=800&q=80',
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Taman Nasional Komodo'],
                    ['icon' => '📍', 'label' => 'Jarak dari Labuan Bajo', 'value' => '25 km boat'],
                    ['icon' => '🕐', 'label' => 'Best Time', 'value' => 'Sunrise'],
                    ['icon' => '🎫', 'label' => 'Retribusi', 'value' => 'Rp 250.000'],
                    ['icon' => '🥾', 'label' => 'Hiking', 'value' => '30-45 mnt'],
                    ['icon' => '📸', 'label' => 'Famous For', 'value' => 'View dari puncak'],
                ],
                'highlights' => [
                    'Panorama tiga warna pantai',
                    'Hiking bukit 360 derajat',
                    'Spot foto paling ikonik',
                    'Sunrise/sunset spectacular',
                    'Tiga pantai berbeda warna',
                    'Compact & tajam',
                ],
            ],
        ];
    }

    /**
     * Show airport transfer page
     */
    public function airport()
    {
        return view('public.airport');
    }
}
