<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASR GO - Travel & Rental Terpercaya di Flores</title>
    <meta name="description" content="ASR GO - Layanan travel antar kota dan airport transfer terpercaya di Pulau Flores, berpusat di Ende. Nyaman, aman, tepat waktu.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }

        /* ===== NAVBAR ===== */
        .navbar-glass {
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(37,99,235,0.08);
        }
        .nav-link {
            color: #4b5563;
            font-weight: 500;
            padding: 0.45rem 0.75rem;
            border-radius: 0.5rem;
            transition: color 0.2s, background 0.2s;
            font-size: 0.875rem;
        }
        .nav-link:hover { color: #2563eb; background: rgba(37,99,235,0.06); }

        /* ===== HERO ===== */
        .hero-section {
            background: linear-gradient(135deg, #0a1a40 0%, #0f2460 25%, #1e3a8a 55%, #1d4ed8 80%, #2563eb 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .hero-orb-1 {
            position: absolute; top: -80px; right: -80px;
            width: 450px; height: 450px;
            background: radial-gradient(circle, rgba(96,165,250,0.2) 0%, transparent 70%);
            border-radius: 50%;
        }
        .hero-orb-2 {
            position: absolute; bottom: -100px; left: -100px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(59,130,246,0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        /* ===== SERVICE TABS ===== */
        .service-tab {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.6rem 1.25rem;
            border-radius: 2rem;
            border: 1.5px solid transparent;
            cursor: pointer;
            transition: all 0.2s ease;
            font-weight: 500; font-size: 0.875rem;
        }
        .service-tab.active {
            background: #2563eb; color: white;
            border-color: #2563eb;
            box-shadow: 0 4px 14px rgba(37,99,235,0.4);
        }
        .service-tab.inactive {
            background: rgba(255,255,255,0.12); color: white;
            border-color: rgba(255,255,255,0.25);
        }
        .service-tab.inactive:hover {
            background: rgba(255,255,255,0.22); border-color: rgba(255,255,255,0.5);
        }

        /* ===== BOOKING CARD ===== */
        .booking-card {
            background: white; border-radius: 1.5rem;
            box-shadow: 0 30px 70px rgba(0,0,0,0.22), 0 8px 24px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .booking-card-header {
            padding: 1.5rem 2rem 1rem;
            border-bottom: 1px solid #f1f5f9;
        }
        .booking-card-body {
            padding: 1.5rem 2rem 2rem;
        }

        /* Form styles */
        .form-field {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.75rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-size: 0.9rem; color: #1e293b;
            background: #f8fafc;
        }
        .form-field:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
            background: white;
        }
        .field-label {
            display: block;
            font-size: 0.72rem; font-weight: 700;
            color: #64748b; text-transform: uppercase;
            letter-spacing: 0.06em; margin-bottom: 0.4rem;
        }

        /* Route badge (for travel) */
        .route-badge {
            display: inline-flex; align-items: center;
            background: #eff6ff; color: #1d4ed8;
            padding: 0.25rem 0.75rem;
            border-radius: 2rem; font-size: 0.75rem;
            font-weight: 600; border: 1px solid #dbeafe;
        }

        /* Airport card */
        .airport-card {
            border: 1.5px solid #e2e8f0;
            border-radius: 0.875rem;
            padding: 0.9rem 1rem;
            cursor: pointer;
            transition: all 0.2s;
            background: #f8fafc;
        }
        .airport-card:hover, .airport-card.selected {
            border-color: #2563eb;
            background: #eff6ff;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }
        .airport-code {
            font-size: 1.1rem; font-weight: 800;
            color: #1e3a8a; letter-spacing: 0.05em;
        }

        /* Transfer type toggle */
        .transfer-toggle {
            display: flex;
            background: #f1f5f9;
            border-radius: 0.875rem;
            padding: 0.25rem;
            gap: 0.25rem;
        }
        .transfer-btn {
            flex: 1; padding: 0.6rem 1rem;
            border-radius: 0.625rem; border: none;
            font-weight: 600; font-size: 0.85rem;
            cursor: pointer; transition: all 0.2s;
            color: #64748b; background: transparent;
        }
        .transfer-btn.active {
            background: white; color: #1d4ed8;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* Btn search */
        .btn-search {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white; padding: 0.875rem 2.5rem;
            border-radius: 0.875rem; font-weight: 700;
            font-size: 0.95rem; transition: all 0.2s;
            border: none; cursor: pointer;
            box-shadow: 0 4px 16px rgba(37,99,235,0.38);
            display: inline-flex; align-items: center; gap: 0.5rem;
        }
        .btn-search:hover {
            transform: translateY(-1.5px);
            box-shadow: 0 8px 24px rgba(37,99,235,0.45);
        }

        /* ===== STATS ===== */
        .stat-card { text-align: center; padding: 2rem 1rem; }
        .stat-number {
            font-size: 2.4rem; font-weight: 900;
            color: #1e3a8a; line-height: 1;
        }
        .stat-label { font-size: 0.875rem; color: #64748b; margin-top: 0.4rem; font-weight: 500; }

        /* ===== SECTION BADGE ===== */
        .section-badge {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: #eff6ff; color: #2563eb;
            padding: 0.35rem 1rem; border-radius: 2rem;
            font-size: 0.78rem; font-weight: 700;
            letter-spacing: 0.03em; border: 1px solid #dbeafe;
            margin-bottom: 0.875rem;
        }

        /* ===== FEATURE CARDS ===== */
        .feature-card {
            background: white; border-radius: 1.125rem;
            padding: 1.75rem 1.5rem;
            border: 1px solid #f1f5f9;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
        }
        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 36px rgba(37,99,235,0.1);
            border-color: #dbeafe;
        }
        .feature-icon {
            width: 3rem; height: 3rem; border-radius: 0.875rem;
            background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1.125rem;
            transition: background 0.25s;
        }
        .feature-card:hover .feature-icon { background: #dbeafe; }

        /* ===== KEUNGGULAN ===== */
        .keunggulan-card {
            display: flex; align-items: flex-start; gap: 1rem;
            padding: 1.5rem;
            background: white;
            border-radius: 1rem;
            border: 1px solid #f1f5f9;
            box-shadow: 0 2px 6px rgba(0,0,0,0.04);
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .keunggulan-card:hover {
            box-shadow: 0 8px 24px rgba(37,99,235,0.1);
            transform: translateY(-2px);
        }
        .keunggulan-icon {
            width: 2.75rem; height: 2.75rem;
            border-radius: 0.75rem; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
        }

        /* ===== DESTINASI ===== */
        .dest-card {
            border-radius: 1.125rem; overflow: hidden;
            background: white;
            border: 1px solid #f1f5f9;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: transform 0.25s, box-shadow 0.25s;
        }
        .dest-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 36px rgba(0,0,0,0.1);
        }
        .dest-img {
            height: 11rem; display: flex; align-items: center;
            justify-content: center; font-size: 4rem;
            position: relative; overflow: hidden;
        }
        .dest-region-tag {
            position: absolute; top: 0.75rem; left: 0.75rem;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(6px);
            color: #1d4ed8; font-size: 0.7rem; font-weight: 700;
            padding: 0.2rem 0.625rem; border-radius: 2rem;
            border: 1px solid rgba(37,99,235,0.2);
        }
        .dest-body { padding: 1.125rem 1.25rem; }
        .dest-title { font-size: 0.95rem; font-weight: 700; color: #0f172a; margin-bottom: 0.3rem; }
        .dest-desc { font-size: 0.8rem; color: #64748b; line-height: 1.5; }
        .dest-distance {
            display: inline-flex; align-items: center; gap: 0.3rem;
            margin-top: 0.75rem;
            font-size: 0.75rem; color: #3b82f6; font-weight: 600;
        }

        /* ===== CTA ===== */
        .cta-section {
            background: linear-gradient(135deg, #0f2460 0%, #1e3a8a 40%, #1d4ed8 75%, #3b82f6 100%);
            position: relative; overflow: hidden;
        }
        .cta-section::after {
            content: '';
            position: absolute; top: 0; right: 0;
            width: 40%; height: 100%;
            background: radial-gradient(ellipse at right, rgba(96,165,250,0.2) 0%, transparent 70%);
        }
        .btn-cta-white {
            background: white; color: #1d4ed8;
            padding: 0.9rem 2.25rem; border-radius: 0.875rem;
            font-weight: 700; font-size: 0.95rem;
            transition: all 0.2s; display: inline-flex;
            align-items: center; gap: 0.5rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        }
        .btn-cta-white:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(0,0,0,0.2); }
        .btn-cta-outline {
            border: 2px solid rgba(255,255,255,0.35);
            color: white; padding: 0.875rem 2rem;
            border-radius: 0.875rem; font-weight: 600;
            font-size: 0.95rem; transition: all 0.2s;
            display: inline-flex; align-items: center;
        }
        .btn-cta-outline:hover { border-color: white; background: rgba(255,255,255,0.1); }

        /* ===== FOOTER ===== */
        .footer-main { background: #080f24; }
        .footer-link { color: #64748b; font-size: 0.875rem; transition: color 0.2s; }
        .footer-link:hover { color: #93c5fd; }

        /* ===== INFO PANEL (travel route info) ===== */
        .info-panel {
            background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%);
            border: 1px solid #dbeafe;
            border-radius: 0.875rem;
            padding: 0.875rem 1.125rem;
            font-size: 0.82rem;
        }

        /* Passenger counter */
        .counter-btn {
            width: 2rem; height: 2rem; border-radius: 50%;
            border: 1.5px solid #e2e8f0;
            background: white; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; font-weight: 700; color: #2563eb;
            transition: all 0.15s;
        }
        .counter-btn:hover { border-color: #2563eb; background: #eff6ff; }

        select option { padding: 0.5rem; }
    </style>
</head>
<body class="bg-white antialiased">

    <!-- ==================== NAVBAR ==================== -->
    <nav class="navbar-glass sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 bg-gradient-to-br from-blue-600 to-blue-900 rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-extrabold text-gray-900">ASR <span class="text-blue-600">GO</span></span>
                        <span class="hidden sm:inline text-xs text-gray-400 font-medium ml-2">Flores</span>
                    </div>
                </div>

                <!-- Nav Links -->
                <div class="hidden md:flex items-center gap-1">
                    <a href="#layanan" class="nav-link">Layanan</a>
                    <a href="#keunggulan" class="nav-link">Keunggulan</a>
                    <a href="#destinasi" class="nav-link">Destinasi</a>
                    <a href="#tentang" class="nav-link">Tentang</a>
                    <a href="#bantuan" class="nav-link">Bantuan</a>
                </div>

                <!-- CTA -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center px-5 py-2 text-blue-600 border-2 border-blue-200 rounded-lg font-semibold hover:border-blue-500 hover:bg-blue-50 transition-all text-sm">
                        Masuk
                    </a>
                    <button class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors text-sm shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span>1500 009</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- ==================== HERO ==================== -->
    <section class="hero-section relative py-20 lg:py-28">
        <div class="hero-orb-1"></div>
        <div class="hero-orb-2"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Hero Text -->
            <div class="text-center mb-10">
                <span class="inline-flex items-center gap-2 bg-white/15 text-white border border-white/20 px-4 py-1.5 rounded-full text-sm font-medium mb-5 backdrop-blur-sm">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    Melayani seluruh rute di Pulau Flores
                </span>
                <h1 class="text-4xl lg:text-5xl xl:text-6xl font-black text-white mb-4 leading-tight">
                    ASR GO Flores,<br>
                    <span class="text-blue-200">Berpusat di Ende</span>
                </h1>
                <p class="text-blue-100/90 text-lg max-w-2xl mx-auto font-medium">
                    Layanan travel antar kota, airport transfer, dan rental kendaraan terpercaya di Pulau Flores
                </p>
            </div>

            <!-- Service Tabs (3 only) -->
            <div class="flex flex-wrap justify-center gap-3 mb-8" id="service-tabs">
                <button class="service-tab active" onclick="switchTab('rental', this)" id="tab-rental">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    ASR Rent Car
                </button>
                <button class="service-tab inactive" onclick="switchTab('travel', this)" id="tab-travel">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    ASR Travel
                </button>
                <button class="service-tab inactive" onclick="switchTab('airport', this)" id="tab-airport">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 0L7 10m5-5l5 5"/></svg>
                    Airport Transfer
                </button>
            </div>

            <!-- ===== BOOKING CARD ===== -->
            <div class="booking-card max-w-5xl mx-auto">

                <!-- ---- PANEL: RENTAL ---- -->
                <div id="panel-rental">
                    <div class="booking-card-header">
                        <div class="flex items-center justify-between flex-wrap gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide">Sewa Kendaraan</p>
                                    <h2 class="text-base font-bold text-gray-900">Berpergian Lebih Bebas #AmanBarengASR</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="booking-card-body">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <label class="field-label">Lokasi Penjemputan</label>
                                <input type="text" placeholder="Ende, Flores" value="Ende" class="form-field">
                            </div>
                            <div>
                                <label class="field-label">Tanggal Mulai</label>
                                <input type="date" value="{{ date('Y-m-d') }}" class="form-field">
                            </div>
                            <div>
                                <label class="field-label">Jam Jemput</label>
                                <input type="time" value="08:00" class="form-field">
                            </div>
                            <div>
                                <label class="field-label">Durasi Sewa</label>
                                <select class="form-field" style="appearance:none; background-image:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 20 20%22><path stroke=%22%236b7280%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%221.5%22 d=%22M6 8l4 4 4-4%22/></svg>'); background-position: right 0.75rem center; background-repeat: no-repeat; background-size: 1.25rem; padding-right: 2.5rem;">
                                    <option>4 Jam / Hari</option>
                                    <option>8 Jam / Hari</option>
                                    <option>12 Jam / Hari</option>
                                    <option>24 Jam (Full Day)</option>
                                    <option>2 Hari</option>
                                    <option>3 Hari</option>
                                    <option>1 Minggu</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="info-panel flex items-center gap-2 flex-1">
                                <svg class="w-4 h-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span class="text-blue-800 font-medium">Tersedia: Avanza, Innova, Hiace, Elf — armada terawat & ber-AC</span>
                            </div>
                            <a href="{{ route('public.vehicles') }}" class="btn-search flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                Cari Kendaraan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- ---- PANEL: TRAVEL (hidden by default) ---- -->
                <div id="panel-travel" style="display:none;">
                    <div class="booking-card-header">
                        <div class="flex items-center justify-between flex-wrap gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide">Travel Antar Kota · Pulau Flores</p>
                                    <h2 class="text-base font-bold text-gray-900">Berpusat di Ende — Melayani Seluruh Kota di Flores</h2>
                                </div>
                            </div>
                            <span class="route-badge">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                                {{ count($travelRoutes ?? []) }} Rute Tersedia
                            </span>
                        </div>
                    </div>
                    <div class="booking-card-body">
                        <div class="info-panel flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-blue-800 font-medium text-sm">✅ Pengemudi berpengalaman · ✅ AC · ✅ Asuransi Perjalanan · ✅ Door-to-door</span>
                        </div>
                        <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-center gap-3">
                            <a href="{{ route('public.travel') }}" class="btn-search">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                Lihat Rute Travel
                            </a>
                        </div>
                    </div>
                </div>

                <!-- ---- PANEL: AIRPORT TRANSFER (hidden by default) ---- -->
                <div id="panel-airport" style="display:none;">
                    <div class="booking-card-header">
                        <div class="flex items-center justify-between flex-wrap gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 0L7 10m5-5l5 5"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide">Airport Transfer · Pulau Flores</p>
                                    <h2 class="text-base font-bold text-gray-900">Antar-Jemput Bandara — 6 Bandara di Flores</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="booking-card-body">
                        <div class="info-panel mb-4">
                            <div class="flex flex-wrap gap-x-6 gap-y-1 text-xs text-blue-800 font-medium">
                                <span>✅ Sudah termasuk tol & parkir</span>
                                <span>✅ Driver standby 30 menit lebih awal</span>
                                <span>✅ Free 1 bagasi besar</span>
                                <span>✅ Konfirmasi instan via WhatsApp</span>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-center gap-3">
                            <button class="btn-search flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                Pesan Airport Transfer
                            </button>
                        </div>
                    </div>
                </div>

            </div><!-- /booking-card -->
        </div>
    </section>

    <!-- ==================== STATS ==================== -->
    <section class="bg-white py-12 border-b border-gray-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-0 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="stat-card border-r border-b lg:border-b-0 border-gray-100">
                    <p class="stat-number">10K+</p>
                    <p class="stat-label">Penumpang Terlayani</p>
                </div>
                <div class="stat-card border-b lg:border-b-0 lg:border-r border-gray-100">
                    <p class="stat-number">{{ count($travelRoutes ?? []) }}</p>
                    <p class="stat-label">Rute Antar Kota</p>
                </div>
                <div class="stat-card border-r border-gray-100">
                    <p class="stat-number">6</p>
                    <p class="stat-label">Bandara Dilayani</p>
                </div>
                <div class="stat-card">
                    <p class="stat-number">98%</p>
                    <p class="stat-label">Tepat Waktu</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== CTA ==================== -->
    <section class="cta-section py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <span class="inline-block bg-white/15 text-white border border-white/25 px-4 py-1.5 rounded-full text-sm font-semibold mb-6 backdrop-blur-sm">
                Mulai Gratis — Tanpa Kartu Kredit
            </span>
            <h2 class="text-4xl lg:text-5xl font-black text-white mb-5 leading-tight">
                Siap Melayani Perjalanan Anda di Flores?
            </h2>
            <p class="text-blue-100 text-base mb-10 max-w-2xl mx-auto">
                Hubungi kami atau daftar sekarang. Tim ASR GO siap membantu merencanakan perjalanan terbaik Anda di Pulau Flores.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('login') }}" class="btn-cta-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Mulai Sekarang
                </a>
                <a href="https://wa.me/621500009" class="btn-cta-outline">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/></svg>
                    WhatsApp Kami
                </a>
            </div>
        </div>
    </section>

    <!-- ==================== FOOTER ==================== -->
    <footer id="tentang" class="footer-main text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 mb-10">
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-2.5 mb-4">
                        <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-extrabold text-xl">ASR GO</p>
                            <p class="text-slate-500 text-xs">Platform Transportasi Flores</p>
                        </div>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-xs">
                        Layanan travel antar kota & airport transfer terpercaya di Pulau Flores, berpusat di Kota Ende, Nusa Tenggara Timur.
                    </p>
                    <div class="mt-5 space-y-1.5">
                        <p class="text-sm text-slate-400">📞 <span class="text-white font-semibold">1500 009</span></p>
                        <p class="text-sm text-slate-400">📍 <span class="text-white font-medium">Jl. Soekarno-Hatta, Ende, NTT</span></p>
                        <p class="text-sm text-slate-400">🕐 <span class="text-white font-medium">Layanan 24 Jam</span></p>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4 text-sm">Layanan</h4>
                    <ul class="space-y-2.5">
                        <li><a href="{{ route('public.travel') }}" class="footer-link">Travel Antar Kota</a></li>
                        <li><a href="{{ route('public.rental') }}" class="footer-link">Sewa Kendaraan</a></li>
                        <li><a href="#" class="footer-link">Airport Transfer</a></li>
                        <li><a href="#" class="footer-link">Paket Wisata</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4 text-sm">Rute Populer</h4>
                    <ul class="space-y-2.5">
                        <li><a href="#" class="footer-link">Ende → Labuan Bajo</a></li>
                        <li><a href="#" class="footer-link">Ende → Maumere</a></li>
                        <li><a href="#" class="footer-link">Ende → Bajawa</a></li>
                        <li><a href="#" class="footer-link">Ende → Kelimutu</a></li>
                        <li><a href="#" class="footer-link">Ende → Ruteng</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4 text-sm">Informasi</h4>
                    <ul class="space-y-2.5">
                        <li><a href="#" class="footer-link">Tentang Kami</a></li>
                        <li><a href="#" class="footer-link">Cara Pemesanan</a></li>
                        <li><a href="#bantuan" class="footer-link">Pusat Bantuan</a></li>
                        <li><a href="#" class="footer-link">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="footer-link">Kebijakan Privasi</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/10 pt-8 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-slate-600 text-sm">&copy; 2026 ASR GO. Seluruh hak dilindungi. &mdash; Ende, Flores, NTT</p>
                <p class="text-slate-600 text-xs">Dibuat dengan ❤️ untuk kemajuan pariwisata Flores</p>
            </div>
        </div>
    </footer>

    <script>
        /* ===== TAB SWITCHING ===== */
        function switchTab(service, el) {
            // Update tab styles
            document.querySelectorAll('.service-tab').forEach(t => {
                t.classList.remove('active');
                t.classList.add('inactive');
            });
            el.classList.remove('inactive');
            el.classList.add('active');

            // Hide all panels
            ['rental','travel','airport'].forEach(p => {
                document.getElementById('panel-' + p).style.display = 'none';
            });
            // Show target panel
            document.getElementById('panel-' + service).style.display = 'block';
        }
    </script>
</body>
</html>
