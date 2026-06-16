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
                            <div class="flex gap-3">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="rental_type" value="driver" checked class="accent-blue-600 w-4 h-4">
                                    <span class="text-gray-700 font-medium text-sm">Dengan Pengemudi</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="rental_type" value="self" class="accent-blue-600 w-4 h-4">
                                    <span class="text-gray-700 font-medium text-sm">Lepas Kunci</span>
                                </label>
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
                            <button class="btn-search flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                Cari Kendaraan
                            </button>
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
                                12 Rute Tersedia
                            </span>
                        </div>
                    </div>
                    <div class="booking-card-body">
                        <!-- Row 1: Origin, Destination, Date, Passengers -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                            <div>
                                <label class="field-label">Kota Asal</label>
                                <div class="form-field bg-blue-50 border-blue-200 text-blue-800 font-semibold flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Ende (Pusat)
                                </div>
                            </div>
                            <div>
                                <label class="field-label">Kota Tujuan</label>
                                <select class="form-field" id="travel-dest" onchange="updateRouteInfo()" style="appearance:none; background-image:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 20 20%22><path stroke=%22%236b7280%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%221.5%22 d=%22M6 8l4 4 4-4%22/></svg>'); background-position: right 0.75rem center; background-repeat: no-repeat; background-size: 1.25rem; padding-right: 2.5rem;">
                                    <option value="">-- Pilih Tujuan --</option>
                                    <optgroup label="🔵 Flores Tengah">
                                        <option value="bajawa" data-dist="85 km" data-dur="±2 jam" data-price="Rp 80.000">Bajawa (Kab. Ngada)</option>
                                        <option value="moni" data-dist="52 km" data-dur="±1,5 jam" data-price="Rp 50.000">Moni / Kelimutu (Kab. Ende)</option>
                                        <option value="detusoko" data-dist="43 km" data-dur="±1 jam" data-price="Rp 40.000">Detusoko (Kab. Ende)</option>
                                    </optgroup>
                                    <optgroup label="🟢 Flores Timur">
                                        <option value="maumere" data-dist="148 km" data-dur="±3 jam" data-price="Rp 120.000">Maumere (Kab. Sikka)</option>
                                        <option value="larantuka" data-dist="240 km" data-dur="±5 jam" data-price="Rp 185.000">Larantuka (Kab. Flores Timur)</option>
                                        <option value="wolowaru" data-dist="63 km" data-dur="±1,5 jam" data-price="Rp 55.000">Wolowaru (Kab. Ende)</option>
                                    </optgroup>
                                    <optgroup label="🟡 Flores Barat">
                                        <option value="riung" data-dist="125 km" data-dur="±3 jam" data-price="Rp 100.000">Riung (Kab. Ngada)</option>
                                        <option value="ruteng" data-dist="198 km" data-dur="±4 jam" data-price="Rp 150.000">Ruteng (Kab. Manggarai)</option>
                                        <option value="laboleng" data-dist="220 km" data-dur="±4,5 jam" data-price="Rp 160.000">Borong (Kab. Manggarai Timur)</option>
                                        <option value="labuanbajo" data-dist="247 km" data-dur="±5,5 jam" data-price="Rp 200.000">Labuan Bajo (Kab. Manggarai Barat)</option>
                                    </optgroup>
                                </select>
                            </div>
                            <div>
                                <label class="field-label">Tanggal Berangkat</label>
                                <input type="date" value="{{ date('Y-m-d') }}" class="form-field">
                            </div>
                            <div>
                                <label class="field-label">Jumlah Penumpang</label>
                                <div class="flex items-center gap-2 form-field" style="padding: 0.5rem 0.875rem;">
                                    <button type="button" class="counter-btn" onclick="changePassenger(-1, 'travel')">−</button>
                                    <span id="travel-pax" class="flex-1 text-center font-bold text-gray-900 text-sm">1 Orang</span>
                                    <button type="button" class="counter-btn" onclick="changePassenger(1, 'travel')">+</button>
                                </div>
                            </div>
                        </div>

                        <!-- Route Info Panel (shows on dest select) -->
                        <div id="travel-route-info" style="display:none;" class="mb-4">
                            <div class="info-panel">
                                <div class="grid grid-cols-3 gap-3 text-center">
                                    <div>
                                        <p class="text-xs text-blue-500 font-semibold uppercase">Jarak</p>
                                        <p class="font-bold text-blue-900 text-sm" id="info-dist">—</p>
                                    </div>
                                    <div class="border-x border-blue-200">
                                        <p class="text-xs text-blue-500 font-semibold uppercase">Est. Waktu</p>
                                        <p class="font-bold text-blue-900 text-sm" id="info-dur">—</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-blue-500 font-semibold uppercase">Tarif / Orang</p>
                                        <p class="font-bold text-blue-900 text-sm" id="info-price">—</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Seat Type -->
                        <div class="mb-4">
                            <label class="field-label mb-2">Tipe Armada</label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                @php
                                $armadas = [
                                    ['icon'=>'🚐','name'=>'Elf / Hiace','cap'=>'12–15 Orang','tag'=>'Populer'],
                                    ['icon'=>'🚌','name'=>'Mini Bus','cap'=>'20–25 Orang','tag'=>'Ekonomis'],
                                    ['icon'=>'🚗','name'=>'Avanza / Innova','cap'=>'4–6 Orang','tag'=>'VIP'],
                                    ['icon'=>'🚙','name'=>'Fortuner / Land','cap'=>'6–7 Orang','tag'=>'Premium'],
                                ];
                                @endphp
                                @foreach($armadas as $a)
                                <label class="airport-card cursor-pointer">
                                    <input type="radio" name="armada_travel" class="hidden" value="{{ $a['name'] }}">
                                    <div class="flex items-center gap-2">
                                        <span class="text-2xl">{{ $a['icon'] }}</span>
                                        <div>
                                            <p class="font-bold text-gray-900 text-xs">{{ $a['name'] }}</p>
                                            <p class="text-gray-500 text-xs">{{ $a['cap'] }}</p>
                                        </div>
                                    </div>
                                    @if($a['tag'] === 'Populer')
                                    <span class="inline-block mt-1 text-xs bg-blue-100 text-blue-700 font-semibold px-2 py-0.5 rounded-full">{{ $a['tag'] }}</span>
                                    @endif
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-2 border-t border-slate-100">
                            <p class="text-xs text-gray-500">
                                ✅ Pengemudi berpengalaman &nbsp;·&nbsp; ✅ AC &nbsp;·&nbsp; ✅ Asuransi Perjalanan &nbsp;·&nbsp; ✅ Door-to-door
                            </p>
                            <button class="btn-search flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                Cari Jadwal
                            </button>
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
                            <!-- Transfer Type Toggle -->
                            <div class="transfer-toggle">
                                <button class="transfer-btn active" onclick="setTransferType('to', this)">
                                    ✈️ Ke Bandara
                                </button>
                                <button class="transfer-btn" onclick="setTransferType('from', this)">
                                    🏠 Dari Bandara
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="booking-card-body">

                        <!-- Airport Selection Grid -->
                        <div class="mb-4">
                            <label class="field-label mb-2">Pilih Bandara</label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-3">
                                @php
                                $airports = [
                                    ['code'=>'EOH','name'=>'Bandara H. Hasan Aroeboesman','city'=>'Ende','dist'=>'13 km dari pusat kota','highlight'=>true],
                                    ['code'=>'LBJ','name'=>'Bandara Komodo','city'=>'Labuan Bajo','dist'=>'2 km dari kota','highlight'=>false],
                                    ['code'=>'MOF','name'=>'Bandara Frans Xavier Seda','city'=>'Maumere','dist'=>'3 km dari kota','highlight'=>false],
                                    ['code'=>'RTG','name'=>'Bandara Frans Sales Lega','city'=>'Ruteng','dist'=>'8 km dari kota','highlight'=>false],
                                    ['code'=>'BJW','name'=>'Bandara Soa','city'=>'Bajawa','dist'=>'24 km dari kota','highlight'=>false],
                                    ['code'=>'LKA','name'=>'Bandara Gewayantana','city'=>'Larantuka','dist'=>'7 km dari kota','highlight'=>false],
                                ];
                                @endphp
                                @foreach($airports as $ap)
                                <label class="airport-card {{ $ap['highlight'] ? 'selected' : '' }} cursor-pointer">
                                    <input type="radio" name="airport_select" class="hidden" value="{{ $ap['code'] }}" {{ $ap['highlight'] ? 'checked' : '' }}>
                                    <div class="flex items-start gap-2.5">
                                        <div class="w-9 h-9 rounded-lg bg-white border border-blue-100 flex items-center justify-center flex-shrink-0 shadow-sm">
                                            <span class="text-xs font-black text-blue-700">{{ $ap['code'] }}</span>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-bold text-gray-900 text-xs truncate">{{ $ap['city'] }}</p>
                                            <p class="text-gray-400 text-xs truncate">{{ $ap['dist'] }}</p>
                                        </div>
                                    </div>
                                    @if($ap['highlight'])
                                    <span class="inline-block mt-1.5 text-xs bg-blue-600 text-white font-semibold px-2 py-0.5 rounded-full">Pusat</span>
                                    @endif
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Form Fields -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                            <div class="lg:col-span-2">
                                <label class="field-label" id="location-label">Lokasi Penjemputan / Hotel</label>
                                <input type="text" placeholder="Masukkan alamat / nama hotel di Ende" class="form-field" id="airport-location">
                            </div>
                            <div>
                                <label class="field-label">Tanggal</label>
                                <input type="date" value="{{ date('Y-m-d') }}" class="form-field">
                            </div>
                            <div>
                                <label class="field-label">Jam Penjemputan</label>
                                <input type="time" value="06:00" class="form-field">
                            </div>
                        </div>

                        <!-- Vehicle Type & Passengers -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="field-label">Tipe Kendaraan</label>
                                <select class="form-field" style="appearance:none; background-image:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 20 20%22><path stroke=%22%236b7280%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%221.5%22 d=%22M6 8l4 4 4-4%22/></svg>'); background-position: right 0.75rem center; background-repeat: no-repeat; background-size: 1.25rem; padding-right: 2.5rem;">
                                    <option>🚗 Sedan / Avanza (1–4 orang)</option>
                                    <option>🚙 Innova / Fortuner (1–6 orang)</option>
                                    <option>🚐 Elf / Hiace (7–15 orang)</option>
                                    <option>🚌 Mini Bus (15–25 orang)</option>
                                </select>
                            </div>
                            <div>
                                <label class="field-label">Jumlah Penumpang</label>
                                <div class="flex items-center gap-2 form-field" style="padding: 0.5rem 0.875rem;">
                                    <button type="button" class="counter-btn" onclick="changePassenger(-1, 'airport')">−</button>
                                    <span id="airport-pax" class="flex-1 text-center font-bold text-gray-900 text-sm">1 Orang</span>
                                    <button type="button" class="counter-btn" onclick="changePassenger(1, 'airport')">+</button>
                                </div>
                            </div>
                        </div>

                        <!-- Tarrif Info -->
                        <div class="info-panel mb-4">
                            <div class="flex flex-wrap gap-x-6 gap-y-1 text-xs text-blue-800 font-medium">
                                <span>✅ Sudah termasuk tol & parkir</span>
                                <span>✅ Driver standby 30 menit lebih awal</span>
                                <span>✅ Free 1 bagasi besar</span>
                                <span>✅ Konfirmasi instan via WhatsApp</span>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-2 border-t border-slate-100">
                            <p class="text-xs text-gray-500">Tarif sudah termasuk BBM · Tidak ada biaya tambahan tersembunyi</p>
                            <button class="btn-search flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                Pesan Sekarang
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
                    <p class="stat-number">12</p>
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

    <!-- ==================== KEUNGGULAN ==================== -->
    <section id="keunggulan" class="bg-slate-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="section-badge">Mengapa ASR GO?</span>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900">Keunggulan Kami</h2>
                <p class="text-gray-500 mt-3 max-w-xl mx-auto text-sm">Komitmen kami untuk memberikan pengalaman perjalanan terbaik di Pulau Flores</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @php
                $keunggulan = [
                    ['icon'=>'🕐','bg'=>'bg-blue-100','title'=>'Tepat Waktu','desc'=>'Pengemudi kami selalu hadir tepat waktu, bahkan 30 menit lebih awal untuk transfer bandara. Perjalanan Anda tidak akan terganggu.'],
                    ['icon'=>'🛡️','bg'=>'bg-green-100','title'=>'Aman & Berlisensi','desc'=>'Semua pengemudi tersertifikasi, berlisensi resmi, dan menjalani pelatihan keselamatan berkala. Kendaraan dilengkapi asuransi perjalanan.'],
                    ['icon'=>'💸','bg'=>'bg-emerald-100','title'=>'Tarif Transparan','desc'=>'Harga sudah termasuk BBM, tol, dan parkir. Tidak ada biaya tersembunyi. Apa yang Anda pesan adalah yang Anda bayar.'],
                    ['icon'=>'📱','bg'=>'bg-purple-100','title'=>'Pesan Mudah','desc'=>'Pemesanan via WhatsApp atau aplikasi, konfirmasi instan, dan tracking real-time. Perjalanan Anda terpantau selalu.'],
                    ['icon'=>'🚗','bg'=>'bg-orange-100','title'=>'Armada Terawat','desc'=>'Semua kendaraan ber-AC, terawat baik, dan dicek rutin. Tersedia Avanza, Innova, Elf, Hiace, hingga Fortuner.'],
                    ['icon'=>'🗺️','bg'=>'bg-cyan-100','title'=>'Hafal Rute Flores','desc'=>'Pengemudi kami asli Flores, hafal setiap sudut jalan, termasuk akses ke destinasi wisata terpencil sekalipun.'],
                    ['icon'=>'⏰','bg'=>'bg-yellow-100','title'=>'Layanan 24 Jam','desc'=>'Call center dan WhatsApp aktif 24 jam, 7 hari seminggu. Kami siap membantu kapanpun Anda butuhkan.'],
                    ['icon'=>'👨‍👩‍👧‍👦','bg'=>'bg-pink-100','title'=>'Cocok untuk Rombongan','desc'=>'Tersedia armada kapasitas besar untuk wisata keluarga, study tour, atau perjalanan bisnis grup.'],
                    ['icon'=>'🤝','bg'=>'bg-indigo-100','title'=>'Dipercaya Ribuan Pelanggan','desc'=>'Lebih dari 10.000 penumpang telah mempercayakan perjalanan mereka kepada ASR GO sejak beroperasi di Ende.'],
                ];
                @endphp
                @foreach($keunggulan as $k)
                <div class="keunggulan-card group">
                    <div class="keunggulan-icon {{ $k['bg'] }}">
                        <span class="text-2xl">{{ $k['icon'] }}</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-1.5">{{ $k['title'] }}</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">{{ $k['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ==================== DESTINASI WISATA FLORES ==================== -->
    <section id="destinasi" class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="section-badge">Jelajahi Flores</span>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900">Destinasi Wisata Populer</h2>
                <p class="text-gray-500 mt-3 max-w-xl mx-auto text-sm">Dari danau tiga warna hingga naga purba — Flores menyimpan keajaiban alam yang menakjubkan</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @php
                $destinasi = [
                    ['emoji'=>'🌋','bg'=>'from-orange-400 to-orange-600','name'=>'Danau Kelimutu','region'=>'Ende','desc'=>'Tiga danau dengan warna berbeda yang berubah secara misterius. Fenomena alam paling ikonik di Flores.','dist'=>'51 km dari Ende'],
                    ['emoji'=>'🐉','bg'=>'from-green-500 to-green-800','name'=>'Taman Nasional Komodo','region'=>'Labuan Bajo','desc'=>'Habitat asli Komodo (Varanus komodoensis), kadal terbesar di dunia. Warisan Alam UNESCO.','dist'=>'247 km dari Ende'],
                    ['emoji'=>'🏖️','bg'=>'from-pink-400 to-rose-600','name'=>'Pink Beach','region'=>'Labuan Bajo','desc'=>'Salah satu dari 7 pantai berpasir merah muda di dunia. Keindahan bawah lautnya luar biasa.','dist'=>'247 km dari Ende'],
                    ['emoji'=>'🏔️','bg'=>'from-slate-500 to-slate-700','name'=>'Pulau Padar','region'=>'Labuan Bajo','desc'=>'Bukit berundak dengan panorama tiga teluk berbeda. Spot foto paling ikonik di Flores.','dist'=>'247 km dari Ende'],
                    ['emoji'=>'🌿','bg'=>'from-emerald-500 to-teal-700','name'=>'Desa Wae Rebo','region'=>'Ruteng','desc'=>'Desa tradisional Manggarai di atas awan 1.200 mdpl. Menang penghargaan UNESCO Asia-Pasifik.','dist'=>'198 km dari Ende'],
                    ['emoji'=>'🕸️','bg'=>'from-lime-500 to-green-600','name'=>'Sawah Lingko','region'=>'Ruteng','desc'=>'Sawah berbentuk jaring laba-laba unik khas Manggarai, dipandang dari atas bukit membentuk pola menakjubkan.','dist'=>'198 km dari Ende'],
                    ['emoji'=>'🏘️','bg'=>'from-amber-500 to-orange-600','name'=>'Kampung Bena','region'=>'Bajawa','desc'=>'Desa adat Ngada dengan megalit kuno dan rumah tradisional yang masih dilestarikan hingga kini.','dist'=>'85 km dari Ende'],
                    ['emoji'=>'🌊','bg'=>'from-cyan-400 to-blue-600','name'=>'Taman Laut 17 Pulau','region'=>'Riung','desc'=>'17 pulau kecil dengan ekosistem terumbu karang yang terjaga, populasi kelelawar raksasa & komodo kerdil.','dist'=>'125 km dari Ende'],
                    ['emoji'=>'🤿','bg'=>'from-blue-500 to-indigo-700','name'=>'Teluk Maumere','region'=>'Maumere','desc'=>'Surga diving dan snorkeling dengan keanekaragaman biota laut tertinggi di Indonesia timur.','dist'=>'148 km dari Ende'],
                    ['emoji'=>'💧','bg'=>'from-sky-400 to-blue-600','name'=>'Air Terjun Cunca Rami','region'=>'Labuan Bajo','desc'=>'Air terjun tersembunyi yang dikelilingi hutan tropis lebat, cocok untuk petualangan alam bebas.','dist'=>'247 km dari Ende'],
                    ['emoji'=>'🏞️','bg'=>'from-teal-400 to-emerald-600','name'=>'Pantai Paga','region'=>'Ende','desc'=>'Pantai eksotis dengan pasir hitam dan batu karang unik, hanya 56 km dari kota Ende.','dist'=>'56 km dari Ende'],
                    ['emoji'=>'⛰️','bg'=>'from-purple-400 to-indigo-600','name'=>'Gunung Iya & Kelimutu','region'=>'Ende','desc'=>'Jalur pendakian aktif dengan pemandangan sunrise spektakuler di kawah Kelimutu yang memesona.','dist'=>'51 km dari Ende'],
                ];
                @endphp
                @foreach($destinasi as $d)
                <div class="dest-card group">
                    <div class="dest-img bg-gradient-to-br {{ $d['bg'] }}">
                        <span class="text-6xl drop-shadow-lg group-hover:scale-110 transition-transform duration-300">{{ $d['emoji'] }}</span>
                        <span class="dest-region-tag">📍 {{ $d['region'] }}</span>
                    </div>
                    <div class="dest-body">
                        <h3 class="dest-title">{{ $d['name'] }}</h3>
                        <p class="dest-desc">{{ $d['desc'] }}</p>
                        <div class="dest-distance">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            {{ $d['dist'] }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-all shadow-md hover:-translate-y-0.5">
                    Pesan Perjalanan ke Destinasi Ini
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- ==================== FITUR PLATFORM ==================== -->
    <section id="layanan" class="bg-slate-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="section-badge">Fitur Platform</span>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900">Kelola Bisnis Anda Lebih Efisien</h2>
                <p class="text-gray-500 mt-3 max-w-xl mx-auto text-sm">Semua alat yang dibutuhkan operator travel & rental dalam satu platform terintegrasi</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @php
                $fitur = [
                    ['path'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'title'=>'Manajemen Booking','desc'=>'Kelola pemesanan travel dan rental secara real-time. Notifikasi otomatis ke pelanggan dan pengemudi.'],
                    ['path'=>'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'title'=>'Analitik & Laporan','desc'=>'Pantau pendapatan, jumlah perjalanan, dan performa driver dengan dashboard analitik yang detail.'],
                    ['path'=>'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title'=>'Tracking Revenue','desc'=>'Monitor pendapatan harian, kelola komisi pengemudi, dan bagi hasil mitra secara otomatis & transparan.'],
                    ['path'=>'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z', 'title'=>'Tracking Real-time','desc'=>'Lacak posisi kendaraan secara langsung. Pelanggan tahu persis posisi pengemudi mereka.'],
                    ['path'=>'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'title'=>'Pembayaran Aman','desc'=>'Integrasi Midtrans untuk pembayaran online. Dompet digital, transfer bank, dan QRIS didukung.'],
                    ['path'=>'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'title'=>'Manajemen Driver','desc'=>'Kelola data, jadwal, dan performa pengemudi. Sistem rating otomatis dari feedback pelanggan.'],
                ];
                @endphp
                @foreach($fitur as $f)
                <div class="feature-card group">
                    <div class="feature-icon">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $f['path'] }}"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 mb-1.5">{{ $f['title'] }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $f['desc'] }}</p>
                </div>
                @endforeach
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
                        <li><a href="#" class="footer-link">Travel Antar Kota</a></li>
                        <li><a href="#" class="footer-link">Airport Transfer</a></li>
                        <li><a href="#" class="footer-link">Sewa Kendaraan</a></li>
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

        /* ===== TRAVEL ROUTE INFO ===== */
        function updateRouteInfo() {
            const sel = document.getElementById('travel-dest');
            const opt = sel.options[sel.selectedIndex];
            const panel = document.getElementById('travel-route-info');

            if (opt.value) {
                document.getElementById('info-dist').textContent = opt.getAttribute('data-dist') || '—';
                document.getElementById('info-dur').textContent = opt.getAttribute('data-dur') || '—';
                document.getElementById('info-price').textContent = opt.getAttribute('data-price') || '—';
                panel.style.display = 'block';
            } else {
                panel.style.display = 'none';
            }
        }

        /* ===== PASSENGER COUNTER ===== */
        var paxCount = { travel: 1, airport: 1 };
        function changePassenger(delta, type) {
            paxCount[type] = Math.max(1, Math.min(50, paxCount[type] + delta));
            const el = document.getElementById(type + '-pax');
            el.textContent = paxCount[type] + (paxCount[type] === 1 ? ' Orang' : ' Orang');
        }

        /* ===== TRANSFER TYPE ===== */
        function setTransferType(type, btn) {
            document.querySelectorAll('.transfer-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const locLabel = document.getElementById('location-label');
            const locInput = document.getElementById('airport-location');

            if (type === 'to') {
                locLabel.textContent = 'Lokasi Penjemputan / Hotel';
                locInput.placeholder = 'Masukkan alamat / nama hotel';
            } else {
                locLabel.textContent = 'Lokasi Tujuan / Hotel';
                locInput.placeholder = 'Masukkan alamat tujuan setelah mendarat';
            }
        }

        /* ===== AIRPORT CARD RADIO ===== */
        document.querySelectorAll('.airport-card').forEach(card => {
            card.addEventListener('click', function() {
                // For armada travel
                const parentGrid = this.closest('.grid');
                if (parentGrid) {
                    parentGrid.querySelectorAll('.airport-card').forEach(c => c.classList.remove('selected'));
                    this.classList.add('selected');
                    const radio = this.querySelector('input[type="radio"]');
                    if (radio) radio.checked = true;
                }
            });
        });
    </script>
</body>
</html>
