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
        $sortBy = $request->input('sort', 'destination_city');
        if (in_array($sortBy, ['destination_city', 'distance_km', 'created_at'])) {
            $query->orderBy($sortBy, $request->input('order', 'asc'));
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

        $sortBy = $request->input('sort', 'vehicle_type');
        if (in_array($sortBy, ['vehicle_type', 'seat_capacity', 'created_at'])) {
            $query->orderBy($sortBy, $request->input('order', 'asc'));
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
        return view('public.vehicles');
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
    public function blogDetail(string $slug)
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
    public function showPage(string $slug)
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

    public function callCenter()
    {
        return view('public.call-center');
    }

    public function cekBooking()
    {
        return view('public.cek-booking');
    }

    private function destinationAsset(string $filename): string
    {
        return asset('images/destinations/' . $filename);
    }

    public function destinasiDetail(string $slug)
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
                'image' => $this->destinationAsset('danau-kelimutu.jpg'),
                'short_desc' => 'Tiga danau kawah dengan warna berbeda yang berubah secara misterius selama bertahun-tahun.',
                'full_desc' => '<p>Danau Kelimutu terletak di puncak Gunung Kelimutu, Kabupaten Ende, Nusa Tenggara Timur. Terdapat tiga danau kawah yang masing-masing memiliki warna berbeda:</p><ul><li><strong>Tiwu Ata Mbupu</strong> (Danau Lanjut Usia) - warna biru</li><li><strong>Tiwu Nuwa Muri Koo Fai</strong> (Danau Pemuda dan Gadis) - warna hijau</li><li><strong>Tiwu Ata Polo</strong> (Danau Bercinta) - warna merah</li></ul><p>Ketiga danau ini dipercaya oleh suku Lio sebagai tempat bersemangnya arwah orang yang telah meninggal. Warna-warna danau ini telah berubah beberapa kali dalam 40 tahun terakhir.</p>',
                'price_start' => 200000,
                'gallery' => [
                    $this->destinationAsset('danau-kelimutu.jpg'),
                    $this->destinationAsset('air-terjun-ogi.jpg'),
                    $this->destinationAsset('pantai-ena-bara.jpg'),
                    $this->destinationAsset('rumah-bung-karno.jpg'),
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
                'image' => $this->destinationAsset('rumah-bung-karno.jpg'),
                'short_desc' => 'Rumah tempat Bung Karno Ir. Soekarno diasingkan tahun 1934-1938. Disini lahir konsep Pancasila.',
                'full_desc' => '<p>Sebelum menjadi Presiden RI, Ir. Soekarno diasingkan oleh pemerintah Belanda ke Ende, Flores (1934-1938). Rumah tempat tinggalnya kini menjadi museum dan cagar budaya.</p><p>Di sinilah Bung Karno banyak merenung dan merumuskan dasar negara Indonesia yang kemudian dinamakan Pancasila. Rumah panggung bersejarah ini menyimpan benda-benda bersejarah termasuk meja tulis dan kursi serta koleksi foto-foto tempo dulu.</p><p>Rumah ini terletak di pusat kota Ende, hanya beberapa menit dari pantai. Di halaman rumah terdapat pohon beringin besar yang dipercaya pernah digunakan Bung Karno untuk berpidato.</p>',
                'price_start' => 50000,
                'gallery' => [
                    $this->destinationAsset('rumah-bung-karno.jpg'),
                    $this->destinationAsset('renungan-bung-karno.jpeg'),
                    $this->destinationAsset('pantai-ena-bara.jpg'),
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
                'image' => $this->destinationAsset('pulau-komodo.avif'),
                'short_desc' => 'Habitat asli komodo (Varanus komodoensis), kadal terbesar di dunia. Warisan Alam UNESCO.',
                'full_desc' => '<p>Pulau Komodo adalah salah satu dari 76 pulau di Taman Nasional Komodo yang ditetapkan sebagai Warisan Alam Dunia UNESCO pada tahun 1991. Pulau ini adalah habitat asli komodo (Varanus komodoensis) dengan populasi sekitar 3.000 ekor.</p><p>Anda bisa trekking bersama ranger untuk melihat komodo di alam liar mereka. Trek wisata tersedia dalam beberapa pilihan rute (short, medium, long) dengan durasi 1-3 jam. Anda juga akan menemui satwa lain seperti rusa, kerbau liar, dan burung.</p>',
                'price_start' => 500000,
                'gallery' => [
                    $this->destinationAsset('pulau-komodo.avif'),
                    $this->destinationAsset('pulau-padar.avif'),
                    $this->destinationAsset('pink-beach.avif'),
                    $this->destinationAsset('pulau-kinde.jpg'),
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
                'image' => $this->destinationAsset('pink-beach.avif'),
                'short_desc' => 'Salah satu dari 7 pantai berpasir merah muda di dunia. Keindahan bawah lautnya luar biasa.',
                'full_desc' => '<p>Pink Beach (Pantai Merah) adalah salah satu dari hanya tujuh pantai berpasir pink di dunia. Warna pink berasal dari campuran pasir putih dengan fragmen karang merah (foraminifera) yang dihancurkan ombak selama ribuan tahun.</p><p>Pantai ini menawarkan snorkeling kelas dunie dengan air super jernih dan biota laut yang berwarna-warni. Anda juga bisa hanya berenang, berjemur, atau dilihat dari bukit untuk panorama terbaik.</p>',
                'price_start' => 300000,
                'gallery' => [
                    $this->destinationAsset('pink-beach.avif'),
                    $this->destinationAsset('pulau-kinde.jpg'),
                    $this->destinationAsset('pantai-koka.jpg'),
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
                'image' => $this->destinationAsset('wae-rebo.jpg'),
                'short_desc' => 'Desa tradisional Manggarai di atas awan 1.200 mdpl dengan rumah kerucut unik. Penghargaan UNESCO.',
                'full_desc' => '<p>Desa Wae Rebo adalah permukiman tradisional terpencil di ketinggian 1.200 mdpl di Manggarai, Flores. Desa ini terkenal dengan rumah adat berbentuk kerucut yang disebut "Mbaru Niang" dan mendapat Penghargaan Konservasi Warisan Budaya UNESCO Asia-Pasifik pada tahun 2012.</p><p>Untuk mencapai desa ini, Anda harus trekking 4.5 km (sekitar 4-5 jam) dari jalan terdekat melewati hujan tropis yang lebat. Tapi semua lelah akan terbayar saat tiba di desa dengan 7 rumah kerucut kuno, ditemani pemandangan awan yang menakjubkan dan keramahan suku Manggarai.</p>',
                'price_start' => 350000,
                'gallery' => [
                    $this->destinationAsset('wae-rebo.jpg'),
                    $this->destinationAsset('taman-wisata-alam-ruteng.jpg'),
                    $this->destinationAsset('sawah-lodok-spiderman.jpg'),
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
                'image' => $this->destinationAsset('kampung-bena.jpg'),
                'short_desc' => 'Desa adat Ngada dengan megalit kuno dan rumah tradisional. Warisan budaya yang dilestarikan.',
                'full_desc' => '<p>Kampung Bena adalah salah satu desa adat Ngada yang paling terkenal, terletak di lereng Gunung Inerie, Kabupaten Ngada. Desa ini memiliki susunan rumah tradisional yang tersusun rata dengan batu-batu megalitik dan altar pemujaan.</p><p>Terdapat 9 suku (kampung) yang tersebar di sekitar Bukit Bena. Anda bisa melihat pakaian tenun ikat asli Ngada, mengunjungi makam batu megalitikum, dan menikmati pemandangan Gunung Inerie dan Bajawa yang hijau. Tiap suku memiliki rumah induk bernama Sa\'o dan panggung pemujaan bernama Nabe.</p>',
                'price_start' => 150000,
                'gallery' => [
                    $this->destinationAsset('kampung-bena.jpg'),
                    $this->destinationAsset('gunung-inerie.jpg'),
                    $this->destinationAsset('air-terjun-ogi.jpg'),
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
                'image' => $this->destinationAsset('teluk-maumere.jpg'),
                'short_desc' => 'Surga diving dan snorkeling dengan keanekaragaman biota laut tertinggi di Indonesia Timur.',
                'full_desc' => '<p>Teluk Maumere, Sikka, Flores, diakui oleh Conservation International sebagai salah satu lokasi penyelaman terbaik di dunia. Di dalam teluk ini terdapat 30+ spot diving dengan biodiversitas laut tertinggi di Sabuk Coral (Coral Triangle).</p><p>Spesies ikan yang bisa Anda temui termasuk hiu paus, manta pari, penyu, napoleon wrasse, dan ikan-ikan karang warna-warni. Selama Perang Dunia II, kapal-kapal karam (Rusia, Jepang, AS) kini menjadi terumbu karang buatan yang indah.</p>',
                'price_start' => 200000,
                'gallery' => [
                    $this->destinationAsset('teluk-maumere.jpg'),
                    $this->destinationAsset('pantai-koka.jpg'),
                    $this->destinationAsset('pulau-kinde.jpg'),
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
            'gua-liang-bua' => [
                'name' => 'Gua Liang Bua',
                'region' => 'Ruteng',
                'slug' => 'gua-liang-bua',
                'image' => $this->destinationAsset('gua-liang-bua.jpeg'),
                'short_desc' => 'Gua kuno dengan stalaktit dan stalagmit indah. Situs budaya Manggarai yang misterius.',
                'full_desc' => '<p>Gua Liang Bua (Gua Kelelawar) adalah gua bersejarah terletak di desa Ruteng, Manggarai. Gua ini terkenal dengan formasi stalaktit dan stalagmit yang menakjubkan, serta populasi kelelawar yang besar.</p><p>Selain keindahan alam, gua ini juga memiliki nilai budaya dan arkeologi yang penting bagi suku Manggarai. Pengalaman menjelajahi gua dengan guide lokal akan memberikan insight tentang kehidupan tradisional masyarakat setempat.</p>',
                'price_start' => 100000,
                'gallery' => [
                    $this->destinationAsset('gua-liang-bua.jpeg'),
                    $this->destinationAsset('taman-wisata-alam-ruteng.jpg'),
                    $this->destinationAsset('sawah-lodok-spiderman.jpg'),
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Ruteng, Manggarai'],
                    ['icon' => '📍', 'label' => 'Jarak dari Ruteng', 'value' => '10 km'],
                    ['icon' => '🕐', 'label' => 'Best Time', 'value' => 'Sepanjang tahun'],
                    ['icon' => '🎫', 'label' => 'Retribusi', 'value' => 'Rp 15.000'],
                    ['icon' => '🦇', 'label' => 'Satwa', 'value' => 'Kelelawar'],
                    ['icon' => '📸', 'label' => 'Tipe', 'value' => 'Gua bersejarah'],
                ],
                'highlights' => [
                    'Gua dengan stalaktit/stalagmit indah',
                    'Kelelawar dalam jumlah besar',
                    'Situs budaya Manggarai',
                    'Arkeologi lokal',
                    'Guide berpengetahuan lokal',
                    'Pengalaman petualangan bawah tanah',
                ],
            ],
            'benteng-lohayong' => [
                'name' => 'Benteng Lohayong',
                'region' => 'Larantuka',
                'slug' => 'benteng-lohayong',
                'image' => $this->destinationAsset('benteng-lohayong.jpg'),
                'short_desc' => 'Benteng bersejarah peninggalan Portugis. Simbol masuknya Kristenitas ke Flores Timur.',
                'full_desc' => '<p>Benteng Lohayong adalah benteng pertahanan yang dibangun oleh Portugis pada abad ke-16 di Larantuka, Flores Timur. Benteng ini menjadi simbol penting dalam sejarah masuknya agama Kristenitas ke Nusa Tenggara Timur.</p><p>Dari puncak benteng, Anda dapat melihat pemandangan laut yang indah dan pulau-pulau sekitarnya. Setiap hari Jumat Agung dan Semana Santa, benteng ini menjadi pusat perayaan tradisi keagamaan yang terkenal dunia.</p>',
                'price_start' => 50000,
                'gallery' => [
                    $this->destinationAsset('benteng-lohayong.jpg'),
                    $this->destinationAsset('bukit-fatima.jpeg'),
                    $this->destinationAsset('pantai-watotena.jpg'),
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Larantuka, Flores Timur'],
                    ['icon' => '📍', 'label' => 'Jarak dari Ende', 'value' => '220 km'],
                    ['icon' => '🕐', 'label' => 'Best Time', 'value' => 'Sepanjang tahun'],
                    ['icon' => '🎫', 'label' => 'Retribusi', 'value' => 'Gratis'],
                    ['icon' => '⛪', 'label' => 'Kategori', 'value' => 'Sejarah & Budaya'],
                    ['icon' => '🏰', 'label' => 'Tipe', 'value' => 'Benteng Portugis'],
                ],
                'highlights' => [
                    'Benteng abad ke-16 peninggalan Portugis',
                    'Situs penting sejarah Kristenitas',
                    'Pemandangan laut spektakuler',
                    'Pusat perayaan Semana Santa',
                    'Arsitektur kolonial bersejarah',
                    'Nilai budaya tinggi',
                ],
            ],
            'semana-santa-larantuka' => [
                'name' => 'Semana Santa Larantuka',
                'region' => 'Larantuka',
                'slug' => 'semana-santa-larantuka',
                'image' => $this->destinationAsset('semana-santa-flotim.jpg'),
                'short_desc' => 'Tradisi Paskah Semana Santa yang mendunia. Perayaan budaya dan keagamaan terbesar di Flores.',
                'full_desc' => '<p>Semana Santa Larantuka adalah perayaan Paskah yang telah berlangsung selama berabad-abad dan dirayakan oleh ribuan orang dari seluruh dunia. Tradisi unik ini menggabungkan elemen keagamaan Kristenitas dengan budaya lokal Flores Timur.</p><p>Selama seminggu penuh, Larantuka mengadakan prosesi, teatrikal, dan berbagai upacara religi yang spektakuler. Pengalaman spiritual dan budaya yang mendalam menanti setiap pengunjung yang datang ke perayaan ini.</p>',
                'price_start' => 0,
                'gallery' => [
                    $this->destinationAsset('semana-santa-flotim.jpg'),
                    $this->destinationAsset('benteng-lohayong.jpg'),
                    $this->destinationAsset('bukit-fatima.jpeg'),
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Larantuka, Flores Timur'],
                    ['icon' => '📍', 'label' => 'Jarak dari Ende', 'value' => '220 km'],
                    ['icon' => '🕐', 'label' => 'Best Time', 'value' => 'Minggu Paskah (Maret/April)'],
                    ['icon' => '🎫', 'label' => 'Tiket', 'value' => 'Gratis (Donasi diterima)'],
                    ['icon' => '⛪', 'label' => 'Kategori', 'value' => 'Spiritual & Budaya'],
                    ['icon' => '👥', 'label' => 'Peserta', 'value' => 'Ribuan per tahun'],
                ],
                'highlights' => [
                    'Perayaan Paskah berusia 400+ tahun',
                    'Pengakuan UNESCO',
                    'Prosesi dan teatrikal spektakuler',
                    'Perpaduan keagamaan dan budaya lokal',
                    'Partisipasi internasional',
                    'Pengalaman spiritual mendalam',
                ],
            ],
            'pulau-padar' => [
                'name' => 'Pulau Padar',
                'region' => 'Labuan Bajo',
                'slug' => 'pulau-padar',
                'image' => $this->destinationAsset('pulau-padar.avif'),
                'short_desc' => 'Bukit berundak dengan panorama tiga teluk berbeda warna. Spot foto paling ikonik di Flores.',
                'full_desc' => '<p>Pulau Padar adalah pulau ketiga terbesar di Taman Nasional Komodo. Pulau ini terkenal dengan bukitnya yang berundak-undak dan bisa di-climb untuk mendapatkan panorama tiga teluk dan pantai yang berbeda warna.</p><p>Hiking ke puncak Padar membutuhkan waktu sekitar 30-45 menit dengan medan yang cukup curam. Tapi sesampainya di puncak, Anda akan disuguhi pemandangan tiga pantai (satu putih, satu pink, satu hitam) yang membentang di pulau-pulau sekitar. Salah satu foto yang paling dicari wisatawan mancanegara!</p>',
                'price_start' => 400000,
                'gallery' => [
                    $this->destinationAsset('pulau-padar.avif'),
                    $this->destinationAsset('pink-beach.avif'),
                    $this->destinationAsset('pulau-komodo.avif'),
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
            'rumah-bung-karno' => [
                'name' => 'Rumah Bung Karno',
                'region' => 'Ende',
                'slug' => 'rumah-bung-karno',
                'image' => $this->destinationAsset('rumah-bung-karno.jpg'),
                'short_desc' => 'Rumah bersejarah tempat pengasingan Ir. Sukarno (1933-1938). Monumen nasional penting.',
                'full_desc' => '<p>Rumah Bung Karno adalah tempat pengasingan Presiden pertama Indonesia, Ir. Sukarno, selama lima tahun (1933-1938) oleh pemerintah Hindia Belanda. Rumah berarsitektur tradisional ini kini menjadi monumen bersejarah dan museum yang penting bagi sejarah Indonesia.</p><p>Selama pengasingan, Sukarno menulis banyak surat dan karya pemikiran politiknya di rumah ini. Pengunjung dapat melihat berbagai koleksi memorabilia, foto, dan tulisan pribadi Sukarno yang bercerita tentang masa-masa sulit namun produktif itu.</p>',
                'price_start' => 50000,
                'gallery' => [
                    $this->destinationAsset('rumah-bung-karno.jpg'),
                    $this->destinationAsset('renungan-bung-karno.jpeg'),
                    $this->destinationAsset('danau-kelimutu.jpg'),
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Ende, Kabupaten Ende'],
                    ['icon' => '📍', 'label' => 'Jarak dari Pusat Ende', 'value' => '5 km'],
                    ['icon' => '🕐', 'label' => 'Jam Operasional', 'value' => '08:00-16:00'],
                    ['icon' => '🎫', 'label' => 'Tiket', 'value' => 'Rp 50.000 (Lokal)'],
                    ['icon' => '📜', 'label' => 'Kategori', 'value' => 'Sejarah Nasional'],
                    ['icon' => '🏛️', 'label' => 'Tipe', 'value' => 'Museum Rumah Bersejarah'],
                ],
                'highlights' => [
                    'Rumah pengasingan Sukarno (1933-1938)',
                    'Monumen Nasional penting',
                    'Koleksi memorabilia Sukarno',
                    'Situs sejarah Indonesia',
                    'Arsitektur tradisional Ende',
                    'Ruang kerja dan ruang tidur asli',
                ],
            ],
            'pantai-ena-bara' => [
                'name' => 'Pantai Ena Bara',
                'region' => 'Ende',
                'slug' => 'pantai-ena-bara',
                'image' => $this->destinationAsset('pantai-ena-bara.jpg'),
                'short_desc' => 'Pantai alami dengan pasir putih lembut dan air laut jernih. Tempat bersantai sempurna.',
                'full_desc' => '<p>Pantai Ena Bara adalah pantai tersembunyi di Ende dengan keindahan alam yang masih alami. Pantai ini menawarkan pasir putih lembut, air laut yang jernih, dan pemandangan sunset yang indah.</p><p>Pantai ini relatif sepi dibandingkan dengan pantai-pantai populer lainnya, menjadikannya tempat yang sempurna untuk bersantai, berenang, atau sekadar menikmati keindahan alam. Cocok untuk piknik keluarga atau merayakan momen spesial.</p>',
                'price_start' => 0,
                'gallery' => [
                    $this->destinationAsset('pantai-ena-bara.jpg'),
                    $this->destinationAsset('teluk-maumere.jpg'),
                    $this->destinationAsset('pantai-koka.jpg'),
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Ena Bara, Ende'],
                    ['icon' => '📍', 'label' => 'Jarak dari Pusat Ende', 'value' => '15 km'],
                    ['icon' => '🕐', 'label' => 'Best Time', 'value' => 'Pagi-Sore'],
                    ['icon' => '🎫', 'label' => 'Tiket', 'value' => 'Gratis'],
                    ['icon' => '🏖️', 'label' => 'Fasilitas', 'value' => 'Warung lokal'],
                    ['icon' => '🌅', 'label' => 'Rekomendasi', 'value' => 'Sunset viewing'],
                ],
                'highlights' => [
                    'Pantai dengan pasir putih lembut',
                    'Air laut jernih dan bersih',
                    'Sepi dan tenang',
                    'Sunset spektakuler',
                    'Cocok untuk berenang',
                    'Picnic spot ideal',
                ],
            ],
            'taman-laut-17-pulau' => [
                'name' => 'Taman Laut 17 Pulau',
                'region' => 'Bajawa',
                'slug' => 'taman-laut-17-pulau',
                'image' => $this->destinationAsset('taman-laut-17-pulau.png'),
                'short_desc' => 'Kawasan laut memukau dengan 17 pulau kecil, pantai eksotis, dan spot snorkeling yang indah.',
                'full_desc' => '<p>Taman Laut 17 Pulau adalah salah satu destinasi bahari yang menarik di kawasan Bajawa. Kawasan ini menyuguhkan pemandangan laut yang indah dengan 17 pulau kecil yang tersebar di sekelilingnya.</p><p>Wisatawan bisa menikmati snorkeling, berenang, dan menjelajah pantai-pantai cantik yang masih alami. Suasana laut yang jernih dan panorama pulau-pulau kecil membuat tempat ini sangat cocok untuk liburan santai maupun foto wisata.</p>',
                'price_start' => 200000,
                'gallery' => [
                    $this->destinationAsset('taman-laut-17-pulau.png'),
                    $this->destinationAsset('pulau-kinde.jpg'),
                    $this->destinationAsset('teluk-maumere.jpg'),
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Bajawa, Ngada'],
                    ['icon' => '📍', 'label' => 'Jarak dari Bajawa', 'value' => '30 km'],
                    ['icon' => '🕐', 'label' => 'Best Time', 'value' => 'Pagi-Sore'],
                    ['icon' => '🎫', 'label' => 'Paket', 'value' => 'Rp 200.000'],
                    ['icon' => '🤿', 'label' => 'Aktivitas', 'value' => 'Snorkeling, berenang'],
                    ['icon' => '🏝️', 'label' => 'Khas', 'value' => '17 pulau kecil'],
                ],
                'highlights' => [
                    '17 pulau kecil yang cantik',
                    'Snorkeling dan berenang',
                    'Laut jernih dan biru',
                    'Pantai eksotis',
                    'Pemandangan bahari memukau',
                    'Cocok untuk wisata santai',
                ],
            ],
            'danau-rana-mese' => [
                'name' => 'Danau Rana Mese',
                'region' => 'Borong',
                'slug' => 'danau-rana-mese',
                'image' => $this->destinationAsset('danau-rana-mese.jpg'),
                'short_desc' => 'Danau pegunungan yang menyajikan pemandangan tenang dan alam yang masih asli.',
                'full_desc' => '<p>Danau Rana Mese adalah destinasi alam yang menawarkan suasana tenang di kawasan pegunungan Borong. Air danau yang tenang diselimuti pemandangan hijau yang menenangkan.</p><p>Tempat ini cocok untuk bersantai, menikmati udara sejuk, dan menikmati panorama alam yang belum terlalu banyak tersentuh oleh wisata komersial.</p>',
                'price_start' => 30000,
                'gallery' => [
                    $this->destinationAsset('danau-rana-mese.jpg'),
                    $this->destinationAsset('air-terjun-cunca-rede.jpg'),
                    $this->destinationAsset('savana-mausui.jpg'),
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Borong, Manggarai Timur'],
                    ['icon' => '📍', 'label' => 'Jarak dari Borong', 'value' => '20 km'],
                    ['icon' => '🕐', 'label' => 'Best Time', 'value' => 'Pagi-Sore'],
                    ['icon' => '🎫', 'label' => 'Retribusi', 'value' => 'Rp 10.000'],
                    ['icon' => '🌿', 'label' => 'Kondisi', 'value' => 'Alam masih asli'],
                    ['icon' => '📸', 'label' => 'Kegiatan', 'value' => 'Foto, piknik'],
                ],
                'highlights' => [
                    'Pemandangan danau yang tenang',
                    'Udara sejuk pegunungan',
                    'Cocok untuk piknik',
                    'Suasana alami dan damai',
                    'Spot foto alam',
                    'Jarak cukup dekat dari pusat kawasan',
                ],
            ],
            'savana-mausui' => [
                'name' => 'Savana Mausui',
                'region' => 'Borong',
                'slug' => 'savana-mausui',
                'image' => $this->destinationAsset('savana-mausui.jpg'),
                'short_desc' => 'Padang savana luas yang menawarkan panorama alam terbuka dan suasana khas pegunungan.',
                'full_desc' => '<p>Savana Mausui adalah hamparan padang rumput yang luas dan terbuka, membentuk pemandangan alam yang unik di kawasan Borong. Udara sejuk dan panorama luas membuat tempat ini cocok untuk menghabiskan waktu santai.</p><p>Area ini sering dipilih wisatawan yang ingin menikmati pemandangan alam dari ketinggian sambil melihat hamparan hijau yang membentang jauh.</p>',
                'price_start' => 25000,
                'gallery' => [
                    $this->destinationAsset('savana-mausui.jpg'),
                    $this->destinationAsset('danau-rana-mese.jpg'),
                    $this->destinationAsset('air-terjun-cunca-rede.jpg'),
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Borong, Manggarai Timur'],
                    ['icon' => '📍', 'label' => 'Jarak dari Borong', 'value' => '25 km'],
                    ['icon' => '🕐', 'label' => 'Best Time', 'value' => 'Pagi-Sore'],
                    ['icon' => '🎫', 'label' => 'Retribusi', 'value' => 'Rp 15.000'],
                    ['icon' => '🌾', 'label' => 'Tipe', 'value' => 'Savana terbuka'],
                    ['icon' => '📸', 'label' => 'Kegiatan', 'value' => 'Foto panorama'],
                ],
                'highlights' => [
                    'Panorama alam luas',
                    'Udara sejuk dan nyaman',
                    'Cocok untuk foto panorama',
                    'Suasana khas pegunungan',
                    'Waktu kunjung yang fleksibel',
                    'Wisata santai yang tenang',
                ],
            ],
            'bunker-jepang-rane' => [
                'name' => 'Bunker Jepang Rane',
                'region' => 'Mbay',
                'slug' => 'bunker-jepang-rane',
                'image' => $this->destinationAsset('bunker-jepang-rane.jpg'),
                'short_desc' => 'Sisa bangunan peninggalan masa perang yang menyimpan jejak sejarah di kawasan Mbay.',
                'full_desc' => '<p>Bunker Jepang Rane adalah salah satu situs sejarah yang masih menyimpan jejak masa lalu di wilayah Mbay. Bangunan peninggalan perang ini menjadi saksi perjalanan sejarah yang pernah terjadi di Flores.</p><p>Tempat ini menarik untuk dikunjungi bagi wisatawan yang ingin memahami sejarah lokal sekaligus menikmati suasana alam sekitarnya yang masih asri.</p>',
                'price_start' => 20000,
                'gallery' => [
                    $this->destinationAsset('bunker-jepang-rane.jpg'),
                    $this->destinationAsset('kampung-adat-kawa.jpg'),
                    $this->destinationAsset('gunung-ebulobo.jpeg'),
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Rane, Mbay'],
                    ['icon' => '📍', 'label' => 'Jarak dari Mbay', 'value' => '15 km'],
                    ['icon' => '🕐', 'label' => 'Best Time', 'value' => 'Pagi-Sore'],
                    ['icon' => '🎫', 'label' => 'Retribusi', 'value' => 'Gratis'],
                    ['icon' => '🏛️', 'label' => 'Kategori', 'value' => 'Sejarah'],
                    ['icon' => '📸', 'label' => 'Kegiatan', 'value' => 'Foto sejarah'],
                ],
                'highlights' => [
                    'Peninggalan sejarah perang',
                    'Jejak masa lalu yang menarik',
                    'Lokasi relatif mudah dijangkau',
                    'Cocok untuk edukasi sejarah',
                    'Kawasan sekitar masih alami',
                    'Foto sejarah dan alam',
                ],
            ],
            'gunung-ebulobo' => [
                'name' => 'Gunung Ebulobo',
                'region' => 'Mbay',
                'slug' => 'gunung-ebulobo',
                'image' => $this->destinationAsset('gunung-ebulobo.jpeg'),
                'short_desc' => 'Gunung yang menawarkan panorama alam luas dan pemandangan hijau yang memikat di kawasan Mbay.',
                'full_desc' => '<p>Gunung Ebulobo menjadi salah satu destinasi alam yang menarik di wilayah Mbay. Pemandangan dari area sekitarnya menawarkan hamparan hutan hijau dan panorama pegunungan yang luas.</p><p>Tempat ini cocok bagi wisatawan yang ingin menikmati alam terbuka, udara sejuk, dan suasana tenang jauh dari keramaian kota.</p>',
                'price_start' => 30000,
                'gallery' => [
                    $this->destinationAsset('gunung-ebulobo.jpeg'),
                    $this->destinationAsset('bunker-jepang-rane.jpg'),
                    $this->destinationAsset('kampung-adat-kawa.jpg'),
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Mbay, Nagekeo'],
                    ['icon' => '📍', 'label' => 'Jarak dari Mbay', 'value' => '20 km'],
                    ['icon' => '🕐', 'label' => 'Best Time', 'value' => 'Pagi-Sore'],
                    ['icon' => '🎫', 'label' => 'Retribusi', 'value' => 'Rp 10.000'],
                    ['icon' => '⛰️', 'label' => 'Tipe', 'value' => 'Pegunungan'],
                    ['icon' => '📸', 'label' => 'Kegiatan', 'value' => 'Foto panorama'],
                ],
                'highlights' => [
                    'Pemandangan alam luas',
                    'Udara sejuk pegunungan',
                    'Cocok untuk trekking santai',
                    'Panorama hijau yang memikat',
                    'Suasana tenang',
                    'Alternatif wisata alam keluarga',
                ],
            ],
            'kampung-adat-kawa' => [
                'name' => 'Kampung Adat Kawa',
                'region' => 'Mbay',
                'slug' => 'kampung-adat-kawa',
                'image' => $this->destinationAsset('kampung-adat-kawa.jpg'),
                'short_desc' => 'Kampung adat yang memperlihatkan tradisi lokal dan suasana kehidupan masyarakat setempat.',
                'full_desc' => '<p>Kampung Adat Kawa adalah salah satu destinasi budaya di wilayah Mbay yang masih mempertahankan tradisi dan cara hidup masyarakat setempat. Kunjungan ke sini memberikan gambaran tentang kehidupan adat yang khas dan penuh makna.</p><p>Wisatawan dapat melihat arsitektur rumah tradisional, kebiasaan lokal, dan nuansa budaya yang masih kental di kawasan tersebut.</p>',
                'price_start' => 15000,
                'gallery' => [
                    $this->destinationAsset('kampung-adat-kawa.jpg'),
                    $this->destinationAsset('bunker-jepang-rane.jpg'),
                    $this->destinationAsset('gunung-ebulobo.jpeg'),
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Kawa, Mbay'],
                    ['icon' => '📍', 'label' => 'Jarak dari Mbay', 'value' => '10 km'],
                    ['icon' => '🕐', 'label' => 'Best Time', 'value' => 'Pagi-Sore'],
                    ['icon' => '🎫', 'label' => 'Retribusi', 'value' => 'Rp 10.000'],
                    ['icon' => '🏡', 'label' => 'Kategori', 'value' => 'Budaya'],
                    ['icon' => '👥', 'label' => 'Kegiatan', 'value' => 'Belajar budaya lokal'],
                ],
                'highlights' => [
                    'Budaya lokal yang masih terjaga',
                    'Arsitektur tradisional khas',
                    'Nuansa kehidupan adat',
                    'Cocok untuk edukasi budaya',
                    'Suasana tenang dan otentik',
                    'Tempat yang nyaman untuk belajar',
                ],
            ],
            'sawah-lodok-spiderman' => [
                'name' => 'Sawah Lodok Spiderman',
                'region' => 'Ruteng',
                'slug' => 'sawah-lodok-spiderman',
                'image' => $this->destinationAsset('sawah-lodok-spiderman.jpg'),
                'short_desc' => 'Sawah dengan terasering bertingkat seperti tangga. Pemandangan alam yang memukau dari atas.',
                'full_desc' => '<p>Sawah Lodok atau lebih dikenal dengan "Sawah Spiderman" adalah persawahan bertingkat di Ruteng, Manggarai, dengan pola terasering yang terlihat seperti jaring laba-laba dari udara.</p><p>Pemandangan dari atas bukit menunjukkan pola geometris yang indah dan teratur, menciptakan lanskap pertanian yang unik dan Instagram-worthy. Tempat ini menggambarkan keahlian masyarakat Manggarai dalam mengelola lahan di daerah berbukit.</p>',
                'price_start' => 100000,
                'gallery' => [
                    $this->destinationAsset('sawah-lodok-spiderman.jpg'),
                    $this->destinationAsset('wae-rebo.jpg'),
                    $this->destinationAsset('taman-wisata-alam-ruteng.jpg'),
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Lodok, Ruteng'],
                    ['icon' => '📍', 'label' => 'Jarak dari Ruteng', 'value' => '20 km'],
                    ['icon' => '🕐', 'label' => 'Best Time', 'value' => 'Pagi (cahaya soft)'],
                    ['icon' => '🎫', 'label' => 'Retribusi', 'value' => 'Rp 20.000'],
                    ['icon' => '📸', 'label' => 'Tipe', 'value' => 'Foto landscape'],
                    ['icon' => '🌾', 'label' => 'Musim', 'value' => 'Tanam & panen'],
                ],
                'highlights' => [
                    'Sawah terasering pola unik',
                    'Terlihat seperti jaring laba-laba',
                    'Pemandangan dari drone spectacular',
                    'Instagram-worthy landscape',
                    'Aktivitas pertanian tradisional',
                    'Geometri alam menakjubkan',
                ],
            ],
            'gunung-inerie' => [
                'name' => 'Gunung Inerie',
                'region' => 'Bajawa',
                'slug' => 'gunung-inerie',
                'image' => $this->destinationAsset('gunung-inerie.jpg'),
                'short_desc' => 'Gunung berapi aktif dengan trekking menantang. Sunrise dari puncak spektakuler.',
                'full_desc' => '<p>Gunung Inerie adalah gunung berapi aktif yang terletak di Kabupaten Ngada, Flores. Gunung ini memiliki ketinggian 2.245 mdpl dan menawarkan trekking yang menantang bagi para pendaki.</p><p>Mendaki Gunung Inerie memerlukan fisik yang kuat dan persiapan yang baik, namun pemandangan sunrise dari puncak sangat spektakuler. Dari puncak, Anda dapat melihat wilayah Bajawa dan pegunungan sekitar yang indah. Aktivitas vulkanologi lokal juga menjadi daya tarik bagi para peneliti.</p>',
                'price_start' => 200000,
                'gallery' => [
                    $this->destinationAsset('gunung-inerie.jpg'),
                    $this->destinationAsset('kampung-bena.jpg'),
                    $this->destinationAsset('air-terjun-ogi.jpg'),
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Bajawa, Ngada'],
                    ['icon' => '📍', 'label' => 'Jarak dari Bajawa', 'value' => '35 km'],
                    ['icon' => '🕐', 'label' => 'Best Time', 'value' => 'Mei-Oktober'],
                    ['icon' => '🎫', 'label' => 'Retribusi', 'value' => 'Rp 100.000'],
                    ['icon' => '⛰️', 'label' => 'Ketinggian', 'value' => '2.245 mdpl'],
                    ['icon' => '🥾', 'label' => 'Trekking', 'value' => '6-8 jam'],
                ],
                'highlights' => [
                    'Gunung berapi aktif 2.245 m',
                    'Trekking menantang',
                    'Sunrise spektakuler dari puncak',
                    'Panorama wilayah Bajawa',
                    'Aktivitas vulkanologi',
                    'Pengalaman pendakian intense',
                ],
            ],
            'pantai-koka' => [
                'name' => 'Pantai Koka',
                'region' => 'Maumere',
                'slug' => 'pantai-koka',
                'image' => $this->destinationAsset('pantai-koka.jpg'),
                'short_desc' => 'Pantai dengan pasir hitam vulkanik dan ekosistem laut yang sehat. Spot diving alternatif.',
                'full_desc' => '<p>Pantai Koka adalah pantai yang kurang terkenal di Maumere dengan karakter unik: pasir hitam vulkanik yang kontras dengan air laut yang jernih. Pantai ini adalah salah satu dari beberapa pantai pasir hitam di Flores.</p><p>Selain keindahan pantai, Pantai Koka juga menawarkan spot diving dan snorkeling yang baik dengan biota laut yang sehat. Pantai ini lebih sepi dibanding pantai-pantai terkenal, menjadikannya pilihan bagus bagi yang mencari ketenangan.</p>',
                'price_start' => 100000,
                'gallery' => [
                    $this->destinationAsset('pantai-koka.jpg'),
                    $this->destinationAsset('teluk-maumere.jpg'),
                    $this->destinationAsset('taman-laut-17-pulau.png'),
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Koka, Maumere'],
                    ['icon' => '📍', 'label' => 'Jarak dari Maumere', 'value' => '25 km'],
                    ['icon' => '🕐', 'label' => 'Best Time', 'value' => 'April-November'],
                    ['icon' => '🎫', 'label' => 'Retribusi', 'value' => 'Gratis'],
                    ['icon' => '🏖️', 'label' => 'Pasir', 'value' => 'Hitam Vulkanik'],
                    ['icon' => '🤿', 'label' => 'Diving', 'value' => 'Tersedia'],
                ],
                'highlights' => [
                    'Pantai pasir hitam vulkanik',
                    'Air laut jernih dan bersih',
                    'Spot diving/snorkeling baik',
                    'Biota laut sehat',
                    'Pantai relatif sepi',
                    'Keindahan kontras alam',
                ],
            ],
            'museum-maumere' => [
                'name' => 'Museum Bikon',
                'region' => 'Maumere',
                'slug' => 'museum-maumere',
                'image' => $this->destinationAsset('rumah-bung-karno.jpg'),
                'short_desc' => 'Museum yang menampilkan sejarah, budaya, dan kebudayaan lokal Maumere secara menarik.',
                'full_desc' => '<p>Museum Maumere menjadi tempat yang tepat untuk mengenal lebih dekat sejarah dan budaya masyarakat setempat. Di sini, pengunjung dapat melihat koleksi yang menggambarkan kehidupan masyarakat, perkembangan daerah, dan warisan budaya yang masih dijaga.</p><p>Tempat ini cocok untuk wisata edukatif yang ingin memahami identitas lokal Maumere lebih dalam.</p>',
                'price_start' => 10000,
                'gallery' => [
                    $this->destinationAsset('rumah-bung-karno.jpg'),
                    $this->destinationAsset('teluk-maumere.jpg'),
                    $this->destinationAsset('pantai-koka.jpg'),
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Maumere, Sikka'],
                    ['icon' => '📍', 'label' => 'Jarak dari pusat kota', 'value' => '5 km'],
                    ['icon' => '🕐', 'label' => 'Best Time', 'value' => 'Pagi-Sore'],
                    ['icon' => '🎫', 'label' => 'Tiket', 'value' => 'Rp 10.000'],
                    ['icon' => '🏛️', 'label' => 'Kategori', 'value' => 'Budaya & Sejarah'],
                    ['icon' => '📚', 'label' => 'Kegiatan', 'value' => 'Edukasi wisata'],
                ],
                'highlights' => [
                    'Sejarah dan budaya lokal',
                    'Koleksi edukatif',
                    'Cocok untuk wisata keluarga',
                    'Mengenal identitas Maumere',
                    'Nuansa belajar yang santai',
                    'Tempat wisata edukasi',
                ],
            ],
            'bukit-fatima' => [
                'name' => 'Bukit Fatima',
                'region' => 'Larantuka',
                'slug' => 'bukit-fatima',
                'image' => $this->destinationAsset('bukit-fatima.jpeg'),
                'short_desc' => 'Bukit dengan patung Maria yang megah. Tempat spiritual dan ziarah Katholik penting.',
                'full_desc' => '<p>Bukit Fatima di Larantuka adalah bukit suci bagi umat Katholik, khususnya bagi mereka yang menyembah Santa Maria. Di puncak bukit terdapat patung Maria yang megah dan menjadi landmark spiritual penting.</p><p>Dari puncak Bukit Fatima, pengunjung dapat melihat kota Larantuka dan selat yang memisahkan Flores dari pulau-pulau sekitarnya. Tempat ini menjadi tujuan ziarah utama terutama selama Semana Santa dan tanggal-tanggal penting dalam kalender Katholik.</p>',
                'price_start' => 0,
                'gallery' => [
                    $this->destinationAsset('bukit-fatima.jpeg'),
                    $this->destinationAsset('benteng-lohayong.jpg'),
                    $this->destinationAsset('pantai-watotena.jpg'),
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Larantuka, Flores Timur'],
                    ['icon' => '📍', 'label' => 'Jarak dari Larantuka Kota', 'value' => '2 km'],
                    ['icon' => '🕐', 'label' => 'Akses', 'value' => 'Sepanjang tahun'],
                    ['icon' => '🎫', 'label' => 'Tiket', 'value' => 'Gratis'],
                    ['icon' => '⛪', 'label' => 'Kategori', 'value' => 'Spiritual/Ziarah'],
                    ['icon' => '🕯️', 'label' => 'Tipe', 'value' => 'Tempat ibadah'],
                ],
                'highlights' => [
                    'Patung Maria megah di puncak',
                    'Tempat ziarah Katholik penting',
                    'Pemandangan kota Larantuka',
                    'Tempat berdoa spiritual',
                    'Panorama selat yang indah',
                    'Destinasi perayaan Semana Santa',
                ],
            ],
            'pantai-watotena' => [
                'name' => 'Pantai Watotena',
                'region' => 'Larantuka',
                'slug' => 'pantai-watotena',
                'image' => $this->destinationAsset('pantai-watotena.jpg'),
                'short_desc' => 'Pantai terindah di Larantuka dengan pasir putih dan air laut yang jernih. Tempat piknik ideal.',
                'full_desc' => '<p>Pantai Watotena adalah pantai terindah di Larantuka dengan pasir putih yang lembut dan air laut yang sangat jernih. Pantai ini menawarkan pemandangan yang eksotis dengan pulau-pulau kecil di depannya.</p><p>Pantai ini cocok untuk berenang, bersantai, berfoto, atau sekadar menikmati keindahan alam pantai tropis. Selain itu, spot snorkeling di sekitar pantai juga cukup baik dengan biota laut yang beragam.</p>',
                'price_start' => 50000,
                'gallery' => [
                    $this->destinationAsset('pantai-watotena.jpg'),
                    $this->destinationAsset('bukit-fatima.jpeg'),
                    $this->destinationAsset('benteng-lohayong.jpg'),
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Watotena, Larantuka'],
                    ['icon' => '📍', 'label' => 'Jarak dari Larantuka Kota', 'value' => '8 km'],
                    ['icon' => '🕐', 'label' => 'Best Time', 'value' => 'Pagi-Sore'],
                    ['icon' => '🎫', 'label' => 'Tiket', 'value' => 'Rp 50.000'],
                    ['icon' => '🏖️', 'label' => 'Pasir', 'value' => 'Putih Lembut'],
                    ['icon' => '🤿', 'label' => 'Snorkeling', 'value' => 'Tersedia'],
                ],
                'highlights' => [
                    'Pantai terindah Larantuka',
                    'Pasir putih lembut',
                    'Air laut jernih kristal',
                    'Spot snorkeling baik',
                    'Pemandangan pulau eksotis',
                    'Tempat piknik sempurna',
                ],
            ],
            'taman-wisata-alam-ruteng' => [
                'name' => 'Taman Wisata Alam Ruteng',
                'region' => 'Ruteng',
                'slug' => 'taman-wisata-alam-ruteng',
                'image' => $this->destinationAsset('taman-wisata-alam-ruteng.jpg'),
                'short_desc' => 'Taman alam dengan trek hiking indah dan vegetasi tropis lebat. Tempat jelajah alam sempurna.',
                'full_desc' => '<p>Taman Wisata Alam Ruteng adalah area konservasi alam yang terletak di sekitar kota Ruteng, Manggarai. Taman ini menawarkan berbagai trek hiking dengan tingkat kesulitan yang bervariasi untuk semua level pejalan kaki.</p><p>Vegetasi tropis yang lebat, air terjun kecil, dan pemandangan alam yang indah menjadi daya tarik utama. Pengunjung dapat menjelajahi hutan, melihat flora dan fauna lokal, dan menikmati udara segar pegunungan.</p>',
                'price_start' => 100000,
                'gallery' => [
                    $this->destinationAsset('taman-wisata-alam-ruteng.jpg'),
                    $this->destinationAsset('wae-rebo.jpg'),
                    $this->destinationAsset('sawah-lodok-spiderman.jpg'),
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Sekitar Ruteng, Manggarai'],
                    ['icon' => '📍', 'label' => 'Jarak dari Ruteng', 'value' => '5 km'],
                    ['icon' => '🕐', 'label' => 'Best Time', 'value' => 'Pagi hari'],
                    ['icon' => '🎫', 'label' => 'Retribusi', 'value' => 'Rp 50.000'],
                    ['icon' => '🥾', 'label' => 'Trek', 'value' => 'Mudah-Sedang'],
                    ['icon' => '🌿', 'label' => 'Tipe', 'value' => 'Hutan Tropis'],
                ],
                'highlights' => [
                    'Taman alam terawat dengan baik',
                    'Trek hiking beragam tingkat',
                    'Vegetasi tropis lebat',
                    'Air terjun kecil indah',
                    'Udara segar pegunungan',
                    'Fauna lokal dapat dilihat',
                ],
            ],
            'pulau-komodo' => [
                'name' => 'Pulau Komodo',
                'region' => 'Labuan Bajo',
                'slug' => 'pulau-komodo',
                'image' => $this->destinationAsset('pulau-komodo.avif'),
                'short_desc' => 'Habitat alami komodo raksasa. Taman Nasional UNESCO dengan satwa langka.',
                'full_desc' => '<p>Pulau Komodo adalah pulau legendaris di Taman Nasional Komodo yang terkenal sebagai habitat asli komodo raksasa. Komodo adalah kadal terbesar di dunia yang hanya ditemukan di kawasan ini.</p><p>Ketika mengunjungi Pulau Komodo, Anda akan dipandu oleh ranger berpengalaman untuk melihat komodo di habitat alaminya. Pengalaman bertemu langsung dengan satwa prasejarah ini adalah pengalaman yang tak terlupakan. Taman Nasional Komodo juga termasuk UNESCO World Heritage Site.</p>',
                'price_start' => 350000,
                'gallery' => [
                    $this->destinationAsset('pulau-komodo.avif'),
                    $this->destinationAsset('pulau-padar.avif'),
                    $this->destinationAsset('pink-beach.avif'),
                ],
                'info' => [
                    ['icon' => '📌', 'label' => 'Lokasi', 'value' => 'Taman Nasional Komodo'],
                    ['icon' => '📍', 'label' => 'Jarak dari Labuan Bajo', 'value' => '35 km boat'],
                    ['icon' => '🕐', 'label' => 'Best Time', 'value' => 'Pagi hari (06:00-09:00)'],
                    ['icon' => '🎫', 'label' => 'Tiket', 'value' => 'Rp 250.000 (wisatawan)'],
                    ['icon' => '🦎', 'label' => 'Satwa', 'value' => 'Komodo raksasa'],
                    ['icon' => '📍', 'label' => 'Tipe', 'value' => 'UNESCO Heritage Site'],
                ],
                'highlights' => [
                    'Habitat asli komodo raksasa',
                    'Satwa prasejarah unik',
                    'Taman Nasional UNESCO',
                    'Trek dengan ranger berlisensi',
                    'Fauna langka Indonesia',
                    'Pengalaman tak terlupakan',
                ],
            ],
        ];

        $destinations['benteng-lohayong-larantuka'] = $destinations['benteng-lohayong'];
        $destinations['bukit-fatima-larantuka'] = $destinations['bukit-fatima'];

        return $destinations;
    }

    /**
     * Show airport transfer page
     */
    public function airport()
    {
        return view('public.airport');
    }
}
