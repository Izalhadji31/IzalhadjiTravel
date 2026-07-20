<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - ASR GO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a', 950: '#172554' },
                        traveloka: { blue: '#0064d2', dark: '#0d2147', light: '#f0f6ff', orange: '#ff5e1c', green: '#00a651' }
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --trvl-blue: #0064d2;
            --trvl-blue-dark: #004ba0;
            --trvl-blue-light: #e8f4fd;
            --trvl-navy: #0d2147;
            --trvl-orange: #ff5e1c;
            --trvl-green: #00a651;
            --trvl-red: #e53935;
            --trvl-yellow: #ffb800;
            --trvl-bg: #f8fafc;
            --trvl-text: #0f172a;
            --trvl-card: #ffffff;
            --trvl-border: #e2e8f0;
            --trvl-gray-100: #f8f9fa;
            --trvl-gray-200: #e9ecef;
            --trvl-gray-300: #dee2e6;
            --trvl-gray-400: #ced4da;
            --trvl-gray-500: #adb5bd;
            --trvl-gray-600: #6c757d;
            --trvl-gray-700: #495057;
            --trvl-gray-800: #343a40;
            --trvl-gray-900: #212529;
            --trvl-shadow-sm: 0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.06);
            --trvl-shadow-md: 0 4px 12px rgba(0,0,0,0.1), 0 2px 4px rgba(0,0,0,0.06);
            --trvl-shadow-lg: 0 10px 30px rgba(0,0,0,0.12), 0 4px 8px rgba(0,0,0,0.06);
            --trvl-shadow-xl: 0 20px 50px rgba(0,0,0,0.15), 0 8px 16px rgba(0,0,0,0.08);
            --trvl-shadow-blue: 0 4px 14px rgba(0,100,210,0.25);
            --trvl-radius-sm: 6px;
            --trvl-radius-md: 10px;
            --trvl-radius-lg: 16px;
            --trvl-radius-xl: 24px;
            --trvl-radius-full: 9999px;
        }

        .dark {
            --trvl-bg: #0f172a;
            --trvl-text: #e2e8f0;
            --trvl-card: #111827;
            --trvl-border: #334155;
            --trvl-gray-100: #111827;
            --trvl-gray-200: #1e293b;
            --trvl-gray-300: #273449;
            --trvl-gray-400: #334155;
            --trvl-gray-500: #475569;
            --trvl-gray-600: #64748b;
            --trvl-gray-700: #94a3b8;
            --trvl-gray-800: #cbd5e1;
            --trvl-gray-900: #e2e8f0;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; }
        html { scroll-behavior: smooth; }
        body { background: var(--trvl-bg); color: var(--trvl-text); -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; transition: background 0.3s ease, color 0.3s ease; }

        .dark .bg-white { background: var(--trvl-card) !important; }
        .dark .bg-blue-50 { background: rgba(59,130,246,0.12) !important; }
        .dark .bg-blue-100 { background: rgba(59,130,246,0.16) !important; }
        .dark .bg-slate-50 { background: #111827 !important; }
        .dark .bg-slate-100 { background: #111827 !important; }
        .dark .bg-gray-100 { background: #111827 !important; }
        .dark .bg-gray-200 { background: #1e293b !important; }
        .dark .bg-gray-300 { background: #1f2937 !important; }
        .dark .border-gray-100, .dark .border-slate-100 { border-color: #334155 !important; }
        .dark .border-blue-200 { border-color: rgba(96,165,250,0.3) !important; }
        .dark .text-gray-900, .dark .text-gray-800, .dark .text-gray-700, .dark .text-blue-900, .dark .text-blue-800, .dark .text-slate-900 { color: #e2e8f0 !important; }
        .dark .text-gray-600, .dark .text-gray-500, .dark .text-gray-400, .dark .text-gray-300 { color: #cbd5e1 !important; }
        .dark .form-field, .dark .trvl-form-field, .dark .bg-card, .dark .bg-section, .dark .airport-card, .dark .booking-card, .dark .info-panel, .dark .trvl-info-panel {
            background: var(--trvl-card) !important;
            color: var(--trvl-text) !important;
            border-color: var(--trvl-border) !important;
        }
        .dark .field-label { color: #cbd5e1 !important; }

        /* ===== TRAVELOKA NAVBAR ===== */
        .trvl-navbar {
            background: var(--trvl-blue);
            padding: 0 2rem;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .trvl-logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: white;
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .trvl-logo-icon {
            width: 36px; height: 36px;
            background: white;
            border-radius: var(--trvl-radius-sm);
            display: flex; align-items: center; justify-content: center;
        }
        .trvl-nav-links { display: flex; align-items: center; gap: 0.5rem; }
        .trvl-nav-link {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: var(--trvl-radius-sm);
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            position: relative;
        }
        .trvl-nav-link:hover { color: white; background: rgba(255,255,255,0.15); }
        .trvl-nav-link.active { color: white; background: rgba(255,255,255,0.2); }
        .trvl-nav-btn {
            padding: 0.5rem 1.25rem;
            border-radius: var(--trvl-radius-sm);
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
        }
        .trvl-nav-btn-outline {
            background: transparent;
            color: white;
            border: 1.5px solid rgba(255,255,255,0.5);
        }
        .trvl-nav-btn-outline:hover { background: rgba(255,255,255,0.15); border-color: white; }
        .trvl-nav-btn-white {
            background: white;
            color: var(--trvl-blue);
        }
        .trvl-nav-btn-white:hover { background: var(--trvl-gray-100); transform: translateY(-1px); box-shadow: var(--trvl-shadow-md); }

        /* ===== TRAVELOKA HERO ===== */
        .trvl-hero {
            background: linear-gradient(135deg, var(--trvl-navy) 0%, #1a3a6c 30%, var(--trvl-blue) 70%, #1e88e5 100%);
            background-size: 400% 400%;
            animation: trvlGradientShift 12s ease infinite;
            position: relative;
            overflow: hidden;
            min-height: 620px;
            display: flex;
            flex-direction: column;
        }
        @keyframes trvlGradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .trvl-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Ccircle cx='30' cy='30' r='1.5'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }
        .trvl-hero-orb {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }
        .trvl-hero-orb-1 {
            top: -150px; right: -100px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(30,136,229,0.2) 0%, transparent 70%);
            animation: trvlFloat 8s ease-in-out infinite;
        }
        .trvl-hero-orb-2 {
            bottom: -100px; left: -80px;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(0,100,210,0.15) 0%, transparent 70%);
            animation: trvlFloat 10s ease-in-out infinite reverse;
        }
        @keyframes trvlFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(15px, -20px) scale(1.03); }
            66% { transform: translate(-10px, 10px) scale(0.97); }
        }
        .trvl-hero-content { padding-top: 3rem; padding-bottom: 1rem; }
        .trvl-hero-badge {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: rgba(255,255,255,0.12);
            color: white;
            border: 1px solid rgba(255,255,255,0.2);
            padding: 0.4rem 1rem;
            border-radius: var(--trvl-radius-full);
            font-size: 0.8rem; font-weight: 600;
            margin-bottom: 1.25rem;
            backdrop-filter: 8px;
            animation: trvlFadeInUp 0.6s ease-out;
        }
        .trvl-hero-badge .pulse-dot {
            width: 8px; height: 8px;
            background: #4ade80;
            border-radius: 50%;
            animation: trvlPulse 2s infinite;
        }
        @keyframes trvlPulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.5); }
        }
        .trvl-hero-title {
            font-size: 2.5rem; font-weight: 900;
            color: white; line-height: 1.15;
            margin-bottom: 1rem;
            animation: trvlFadeInUp 0.6s ease-out 0.1s both;
        }
        .trvl-hero-title .highlight {
            background: linear-gradient(135deg, #93c5fd, #bfdbfe);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .trvl-hero-subtitle {
            color: rgba(191,219,254,0.9);
            font-size: 1rem; max-width: 520px;
            line-height: 1.6; font-weight: 400;
            animation: trvlFadeInUp 0.6s ease-out 0.2s both;
        }
        @keyframes trvlFadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ===== TRAVELOKA SERVICE TABS ===== */
        .trvl-service-tabs {
            display: flex; flex-wrap: wrap; justify-content: center; gap: 0.5rem;
            margin-bottom: 1.5rem;
            animation: trvlFadeInUp 0.6s ease-out 0.3s both;
        }
        .trvl-service-tab {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.7rem 1.5rem;
            border-radius: var(--trvl-radius-full);
            border: 1.5px solid transparent;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 600; font-size: 0.875rem;
        }
        .trvl-service-tab.active {
            background: white; color: var(--trvl-blue);
            border-color: white;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }
        .trvl-service-tab.inactive {
            background: rgba(255,255,255,0.1); color: white;
            border-color: rgba(255,255,255,0.2);
        }
        .trvl-service-tab.inactive:hover {
            background: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.4);
            transform: translateY(-1px);
        }

        /* ===== TRAVELOKA BOOKING CARD ===== */
        .trvl-booking-wrapper { animation: trvlFadeInUp 0.7s ease-out 0.4s both; }
        .trvl-booking-card {
            background: var(--trvl-card);
            border: 1px solid var(--trvl-border);
            border-radius: var(--trvl-radius-xl);
            box-shadow: 0 30px 80px rgba(0,0,0,0.2), 0 10px 30px rgba(0,0,0,0.12);
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .trvl-booking-card:hover { transform: translateY(-2px); }
        .trvl-booking-header {
            padding: 1.5rem 2rem 1rem;
            border-bottom: 1px solid var(--trvl-border);
        }
        .trvl-booking-body { padding: 1.5rem 2rem 2rem; }
        .trvl-booking-panel { display: none; animation: trvlFadeSlideIn 0.35s ease-out; }
        .trvl-booking-panel.active { display: block; }
        @keyframes trvlFadeSlideIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .trvl-form-field {
            width: 100%; padding: 0.75rem 1rem;
            border: 1.5px solid var(--trvl-border);
            border-radius: var(--trvl-radius-md);
            outline: none; transition: all 0.2s;
            font-size: 0.9rem; color: var(--trvl-text);
            background: var(--trvl-bg);
        }
        .trvl-form-field:focus {
            border-color: var(--trvl-blue);
            box-shadow: 0 0 0 3px rgba(0,100,210,0.1);
            background: var(--trvl-card);
        }
        .trvl-field-label {
            display: block; font-size: 0.7rem; font-weight: 700;
            color: var(--trvl-gray-600); text-transform: uppercase;
            letter-spacing: 0.06em; margin-bottom: 0.4rem;
        }
        .trvl-btn-search {
            background: linear-gradient(135deg, var(--trvl-blue) 0%, var(--trvl-blue-dark) 100%);
            color: white; padding: 0.875rem 2.5rem;
            border-radius: var(--trvl-radius-md); font-weight: 700;
            font-size: 0.95rem; transition: all 0.25s;
            border: none; cursor: pointer;
            box-shadow: 0 4px 16px rgba(0,100,210,0.38);
            display: inline-flex; align-items: center; gap: 0.5rem;
        }
        .trvl-btn-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(0,100,210,0.5);
        }
        .trvl-btn-search:active { transform: translateY(0); }
        .trvl-info-panel {
            background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%);
            border: 1px solid #dbeafe;
            border-radius: var(--trvl-radius-md);
            padding: 0.875rem 1.125rem;
            font-size: 0.82rem;
        }
        .dark .trvl-info-panel {
            background: rgba(59, 130, 246, 0.16);
            border-color: rgba(96, 165, 250, 0.28);
            color: #dbeafe;
        }
        .dark .trvl-booking-card {
            background: var(--trvl-card);
        }
        .dark .trvl-vehicle-card-img img,
        .dark .trvl-route-card-img img {
            filter: brightness(0.95);
        }
        .dark .trvl-route-card-body h4,
        .dark .trvl-route-card-body .font-bold.text-gray-900,
        .dark .trvl-route-card-body h3,
        .dark .trvl-route-card-body h2 {
            color: var(--trvl-gray-100);
        }
        .dark .trvl-route-card-body p,
        .dark .trvl-route-card-body .text-gray-500 {
            color: var(--trvl-gray-400);
        }
        .dark .trvl-route-card-body .text-amber-600 {
            color: #fbbf24;
        }

        /* ===== TRAVELOKA TRUST BADGES ===== */
        .trvl-trust-section {
            background: var(--trvl-bg);
            padding: 2rem 0;
            border-bottom: 1px solid var(--trvl-border);
        }
        .trvl-trust-badge {
            display: flex; align-items: center; justify-content: center;
            height: 3.5rem; padding: 0 1.5rem;
            background: var(--trvl-card); border-radius: var(--trvl-radius-md);
            border: 1px solid var(--trvl-border);
            transition: all 0.3s ease;
            font-size: 0.8rem; font-weight: 700; color: var(--trvl-gray-600);
        }
        .trvl-trust-badge:hover {
            border-color: var(--trvl-blue);
            box-shadow: 0 4px 16px rgba(0,100,210,0.08);
            transform: translateY(-2px);
            color: var(--trvl-blue);
        }

        /* ===== TRAVELOKA SECTION ===== */
        .trvl-section { padding: 4rem 0; }
        .trvl-section-bg { background: var(--trvl-bg); }
        .trvl-section-white-bg { background: var(--trvl-card); }
        .trvl-section-badge {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: var(--trvl-orange); color: white;
            padding: 0.35rem 1rem; border-radius: var(--trvl-radius-full);
            font-size: 0.78rem; font-weight: 700;
            border: 1px solid rgba(0,0,0,0.04); margin-bottom: 0.875rem;
        }
        .trvl-section-title {
            font-size: 1.75rem; font-weight: 800;
            color: var(--trvl-gray-900);
            line-height: 1.25; margin-bottom: 0.75rem;
        }
        .trvl-section-desc {
            font-size: 0.95rem; color: var(--trvl-gray-600);
            max-width: 600px; line-height: 1.6;
        }
        .trvl-section-header-center { text-align: center; }
        .trvl-section-header-center .trvl-section-desc { margin: 0 auto; }

        /* ===== TRAVELOKA FEATURE CARDS ===== */
        .trvl-feature-card {
            background: var(--trvl-card);
            border-radius: var(--trvl-radius-lg);
            padding: 1.75rem 1.5rem;
            border: 1px solid var(--trvl-border);
            box-shadow: var(--trvl-shadow-sm);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            position: relative; overflow: hidden;
        }
        .trvl-feature-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--trvl-blue), #60a5fa);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        .trvl-feature-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--trvl-shadow-lg);
            border-color: var(--trvl-border);
        }
        .trvl-feature-card:hover::before { transform: scaleX(1); }
        .trvl-feature-icon {
            width: 3.5rem; height: 3.5rem;
            border-radius: var(--trvl-radius-md);
            background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1.25rem;
            transition: all 0.3s ease;
        }
        .trvl-feature-card:hover .trvl-feature-icon {
            background: linear-gradient(135deg, var(--trvl-blue) 0%, #60a5fa 100%);
        }
        .trvl-feature-card:hover .trvl-feature-icon svg { color: white; }
        .trvl-feature-icon svg { color: var(--trvl-blue); transition: color 0.3s; }
        .trvl-feature-title { font-size: 1rem; font-weight: 700; color: var(--trvl-gray-900); margin-bottom: 0.5rem; }
        .trvl-feature-desc { font-size: 0.85rem; color: var(--trvl-gray-600); line-height: 1.6; }

        /* ===== TRAVELOKA ROUTE CARDS ===== */
        .trvl-route-card {
            background: var(--trvl-card);
            border-radius: var(--trvl-radius-lg);
            border: 1px solid var(--trvl-border);
            box-shadow: var(--trvl-shadow-sm);
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            display: flex; flex-direction: column;
        }
        .trvl-route-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--trvl-shadow-lg);
            border-color: #dbeafe;
        }
        .trvl-route-card-img {
            height: 10rem;
            background: linear-gradient(135deg, var(--trvl-navy) 0%, var(--trvl-blue) 50%, #60a5fa 100%);
            display: flex; align-items: center; justify-content: center;
            font-size: 3.5rem; position: relative; overflow: hidden;
        }
        .trvl-route-card-img::after {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(to bottom, transparent 50%, rgba(0,0,0,0.15) 100%);
        }
        .trvl-route-card-body { padding: 1.25rem; flex: 1; display: flex; flex-direction: column; }
        .trvl-route-origin-dest {
            display: flex; align-items: center; gap: 0.5rem;
            margin-bottom: 0.75rem;
        }
        .trvl-route-city { font-weight: 700; font-size: 0.9rem; color: var(--trvl-gray-900); }
        .trvl-route-arrow { color: var(--trvl-blue); font-size: 1.1rem; }
        .trvl-route-meta {
            display: flex; align-items: center; gap: 1rem;
            margin-bottom: 0.75rem; flex-wrap: wrap;
        }
        .trvl-route-meta-item {
            display: inline-flex; align-items: center; gap: 0.25rem;
            font-size: 0.75rem; color: var(--trvl-gray-600); font-weight: 500;
        }
        .trvl-route-price {
            font-size: 1.15rem; font-weight: 800; color: var(--trvl-blue);
            margin-bottom: 1rem;
        }
        .trvl-route-price span { font-size: 0.75rem; font-weight: 500; color: var(--trvl-gray-500); }
        .trvl-btn-pesan {
            display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem;
            background: var(--trvl-blue); color: white;
            padding: 0.65rem 1.25rem; border-radius: var(--trvl-radius-md);
            font-weight: 600; font-size: 0.85rem;
            transition: all 0.25s; border: none; cursor: pointer;
            margin-top: auto; text-decoration: none;
        }
        .trvl-btn-pesan:hover {
            background: var(--trvl-blue-dark);
            transform: translateY(-1px);
            box-shadow: var(--trvl-shadow-blue);
        }

        /* ===== TRAVELOKA VEHICLE CARDS ===== */
        .trvl-vehicle-card {
            background: var(--trvl-card);
            border-radius: var(--trvl-radius-lg);
            border: 1px solid var(--trvl-border);
            box-shadow: var(--trvl-shadow-sm);
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
        }
        .trvl-vehicle-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--trvl-shadow-blue);
            border-color: #bfdbfe;
        }
        .trvl-vehicle-card-img {
            height: 11rem;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden;
        }
        .trvl-vehicle-card-img img {
            width: 100%; height: 100%; object-fit: cover; display: block;
        }
        .trvl-vehicle-card-img::after {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(to bottom, transparent 40%, rgba(0,0,0,0.2) 100%);
        }
        .trvl-vehicle-card-body { padding: 1.25rem; }
        .trvl-vehicle-name { font-size: 1rem; font-weight: 700; color: var(--trvl-gray-900); margin-bottom: 0.5rem; }
        .trvl-vehicle-specs { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 0.75rem; }
        .trvl-vehicle-spec {
            display: inline-flex; align-items: center; gap: 0.25rem;
            font-size: 0.72rem; color: var(--trvl-gray-600);
            background: var(--trvl-gray-100); padding: 0.2rem 0.5rem;
            border-radius: 0.375rem; font-weight: 500;
        }
        .trvl-vehicle-price { font-size: 1.1rem; font-weight: 800; color: var(--trvl-blue); }
        .trvl-vehicle-price span { font-size: 0.72rem; font-weight: 500; color: var(--trvl-gray-500); }

        /* ===== TRAVELOKA STATS ===== */
        .trvl-stats-section {
            padding: 2.5rem 0;
            border-bottom: 1px solid var(--trvl-border);
            background: var(--trvl-card);
        }
        .trvl-stats-grid {
            background: var(--trvl-card);
            border: 1px solid var(--trvl-border);
        }
        .trvl-stat-card { text-align: center; padding: 2rem 1rem; }
        .trvl-stat-card-border { border-right: 1px solid var(--trvl-border); }
        .trvl-stat-number { font-size: 2.4rem; font-weight: 900; color: var(--trvl-blue); line-height: 1; }
        .trvl-stat-label { font-size: 0.875rem; color: var(--trvl-gray-600); margin-top: 0.4rem; font-weight: 500; }
        .dark .trvl-stat-number { color: #60a5fa; }

        /* ===== TRAVELOKA CTA ===== */
        .trvl-cta-section {
            background: linear-gradient(135deg, #0f2460 0%, #1e3a8a 40%, var(--trvl-blue) 75%, #3b82f6 100%);
            position: relative; overflow: hidden;
        }
        .trvl-cta-section::after {
            content: '';
            position: absolute; top: 0; right: 0;
            width: 40%; height: 100%;
            background: radial-gradient(ellipse at right, rgba(96,165,250,0.2) 0%, transparent 70%);
        }
        .trvl-btn-cta-white {
            background: white; color: var(--trvl-blue-dark);
            padding: 0.9rem 2.25rem; border-radius: var(--trvl-radius-md);
            font-weight: 700; font-size: 0.95rem;
            transition: all 0.25s; display: inline-flex;
            align-items: center; gap: 0.5rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
            text-decoration: none;
        }
        .trvl-btn-cta-white:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(0,0,0,0.2); }
        .trvl-btn-cta-outline {
            border: 2px solid rgba(255,255,255,0.35);
            color: white; padding: 0.875rem 2rem;
            border-radius: var(--trvl-radius-md); font-weight: 600;
            font-size: 0.95rem; transition: all 0.25s;
            display: inline-flex; align-items: center;
            text-decoration: none;
        }
        .trvl-btn-cta-outline:hover { border-color: white; background: rgba(255,255,255,0.1); }

        /* ===== TRAVELOKA FOOTER ===== */
        .trvl-footer { background: #080f24; }
        .trvl-footer-link { color: #64748b; font-size: 0.875rem; transition: color 0.2s; text-decoration: none; }
        .trvl-footer-link:hover { color: #93c5fd; }
        .trvl-footer-heading { font-weight: 700; color: white; font-size: 0.875rem; margin-bottom: 1rem; }
        .trvl-footer-brand { font-weight: 800; color: white; font-size: 1.25rem; }
        .trvl-footer-brand span { color: var(--trvl-blue); }

        /* ===== TRAVELOKA SCROLL REVEAL ===== */
        .trvl-reveal {
            opacity: 0; transform: translateY(30px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .trvl-reveal.visible { opacity: 1; transform: translateY(0); }
        .trvl-reveal-delay-1 { transition-delay: 0.1s; }
        .trvl-reveal-delay-2 { transition-delay: 0.2s; }
        .trvl-reveal-delay-3 { transition-delay: 0.3s; }

        /* ===== TRAVELOKA MOBILE MENU ===== */
        .trvl-mobile-menu {
            display: none;
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: white; z-index: 100;
            padding: 5rem 2rem 2rem;
        }
        .trvl-mobile-menu.open { display: block; animation: trvlFadeInUp 0.3s ease-out; }
        .trvl-mobile-menu a {
            display: block; padding: 1rem 0;
            font-size: 1.1rem; font-weight: 600; color: var(--trvl-gray-900);
            border-bottom: 1px solid var(--trvl-gray-200);
            text-decoration: none;
        }
        .trvl-hamburger { display: none; }
        @media (max-width: 767px) {
            .trvl-hamburger { display: flex; }
            .trvl-nav-links-desktop { display: none; }
            .trvl-hero-title { font-size: 1.85rem; }
            .trvl-section-title { font-size: 1.5rem; }
            .trvl-booking-header { padding: 1.25rem 1.25rem 0.75rem; }
            .trvl-booking-body { padding: 1.25rem; }
        }

        /* ===== CONTAINER ===== */
        .trvl-container { max-width: 1200px; margin: 0 auto; padding: 0 1.25rem; }
        @media (min-width: 640px) { .trvl-container { padding: 0 1.5rem; } }
        @media (min-width: 1024px) { .trvl-container { padding: 0 2rem; } }
        @media (min-width: 640px) { .trvl-hero-title { font-size: 3rem; } }
        @media (min-width: 1024px) { .trvl-hero-title { font-size: 3.75rem; } }
        @media (min-width: 1280px) { .trvl-hero-title { font-size: 4.25rem; } }
        @media (min-width: 640px) { .trvl-hero-subtitle { font-size: 1.125rem; } }
        @media (min-width: 1024px) { .trvl-section-title { font-size: 2.25rem; } }
        @media (min-width: 1024px) { .trvl-section { padding: 5rem 0; } }

        /* Toast Animation */
        @keyframes trvlToastSlideIn {
            from { transform: translateX(120%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* ===== SKELETON LOADING ===== */
        .skeleton {
            background: linear-gradient(90deg, #e5e7eb 25%, #f3f4f6 50%, #e5e7eb 75%);
            background-size: 200% 100%;
            animation: skeleton-pulse 1.5s ease-in-out infinite;
            border-radius: 0.375rem;
            color: transparent !important;
            user-select: none;
            pointer-events: none;
        }
        .skeleton-text { height: 0.875rem; margin-bottom: 0.5rem; width: 100%; }
        .skeleton-text-sm { width: 60%; }
        .skeleton-text-lg { width: 80%; height: 1.25rem; }
        .skeleton-avatar { width: 2.5rem; height: 2.5rem; border-radius: 9999px; }
        .skeleton-card { height: 8rem; border-radius: 0.625rem; margin-bottom: 1rem; }
        .skeleton-button { width: 6rem; height: 2.25rem; border-radius: 0.5rem; }
        @keyframes skeleton-pulse {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* ===== TOAST NOTIFICATION (fixed) ===== */
        .toast-fixed {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            z-index: 9999;
            max-width: 380px;
            min-width: 280px;
            padding: 1rem 1.25rem;
            border-radius: 0.75rem;
            background: var(--trvl-card, #ffffff);
            border: 1px solid var(--trvl-border, #e5e7eb);
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            animation: toastSlideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes toastSlideIn {
            from { transform: translateX(120%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .toast-fixed.toast-exit {
            animation: toastSlideOut 0.3s ease-in forwards;
        }
        @keyframes toastSlideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(120%); opacity: 0; }
        }

        /* ===== MODAL (SweetAlert-style) ===== */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 9998;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: modalFadeIn 0.2s ease-out;
        }
        @keyframes modalFadeIn { from { opacity: 0; } to { opacity: 1; } }
        .modal-content {
            background: var(--trvl-card, #fff);
            border-radius: 1rem;
            padding: 2rem;
            max-width: 420px;
            width: 90%;
            box-shadow: 0 25px 60px rgba(0,0,0,0.3);
            animation: modalContentSlide 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
        }
        @keyframes modalContentSlide {
            from { transform: scale(0.85) translateY(20px); opacity: 0; }
            to { transform: scale(1) translateY(0); opacity: 1; }
        }
        .modal-icon {
            width: 4rem; height: 4rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.75rem;
        }
        .modal-icon.success { background: #d1fae5; color: #059669; }
        .modal-icon.error { background: #fee2e2; color: #dc2626; }
        .modal-icon.warning { background: #fef3c7; color: #d97706; }
        .modal-icon.info { background: #dbeafe; color: #2563eb; }
        .modal-title { font-size: 1.25rem; font-weight: 700; color: var(--trvl-text, #1a1a1a); margin-bottom: 0.5rem; }
        .modal-desc { font-size: 0.9rem; color: var(--trvl-gray-600, #6c757d); margin-bottom: 1.5rem; line-height: 1.5; }
        .modal-btn { padding: 0.75rem 2rem; border-radius: 0.5rem; font-weight: 600; font-size: 0.9rem; border: none; cursor: pointer; transition: all 0.2s; min-width: 120px; }
        .modal-btn-primary { background: #2563eb; color: white; }
        .modal-btn-primary:hover { background: #1d4ed8; }
        .modal-btn-secondary { background: #e5e7eb; color: #111; }
        .modal-btn-secondary:hover { background: #d1d5db; }
        .modal-btn-danger { background: #dc2626; color: white; }
        .modal-btn-danger:hover { background: #b91c1c; }

        /* ===== COMPARISON TABLE ===== */
        .trvl-comparison-table {
            width: 100%;
            border-collapse: collapse;
            border-radius: var(--trvl-radius-lg);
            overflow: hidden;
            box-shadow: var(--trvl-shadow-md);
            font-size: 0.9rem;
        }
        .trvl-comparison-table thead {
            background: linear-gradient(135deg, var(--trvl-navy) 0%, var(--trvl-blue) 100%);
        }
        .trvl-comparison-table th {
            color: white;
            padding: 1rem 1.25rem;
            text-align: left;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .th-asr, .th-trac {
            text-align: center;
            min-width: 180px;
        }
        .table-brand {
            display: block;
            font-size: 1.1rem;
            font-weight: 800;
            text-transform: none;
            letter-spacing: 0;
        }
        .table-brand-sub {
            display: block;
            font-size: 0.7rem;
            font-weight: 500;
            opacity: 0.75;
            text-transform: none;
            letter-spacing: 0;
            margin-top: 0.15rem;
        }
        .trvl-comparison-table tbody tr {
            transition: background 0.2s ease;
        }
        .trvl-comparison-table tbody tr:hover {
            background: rgba(0,100,210,0.05);
        }
        .dark .trvl-comparison-table tbody tr:hover {
            background: rgba(96,165,250,0.1);
        }
        .trvl-comparison-table tbody tr.tr-highlight {
            background: rgba(0,100,210,0.03);
        }
        .dark .trvl-comparison-table tbody tr.tr-highlight {
            background: rgba(96,165,250,0.05);
        }
        .trvl-comparison-table td {
            padding: 0.85rem 1.25rem;
            border-bottom: 1px solid var(--trvl-border);
            color: var(--trvl-gray-700);
        }
        .trvl-comparison-table tbody tr:last-child td {
            border-bottom: none;
        }
        .td-label {
            font-weight: 600;
            color: var(--trvl-gray-800);
            white-space: nowrap;
        }
        .td-asr, .td-trac {
            text-align: center;
            font-weight: 500;
        }
        .td-asr { color: #059669; }
        .td-trac { color: var(--trvl-gray-600); }
        .dark .td-label { color: var(--trvl-gray-200); }
        .dark .td-asr { color: #34d399; }
        .dark .td-trac { color: var(--trvl-gray-400); }
        .dark .trvl-comparison-table td {
            color: var(--trvl-gray-300);
        }
        .dark .trvl-comparison-table tbody {
            background: var(--trvl-card);
        }
        .trvl-comparison-table thead th:first-child {
            border-radius: 0;
        }
        @media (max-width: 767px) {
            .trvl-comparison-table {
                font-size: 0.75rem;
            }
            .trvl-comparison-table th,
            .trvl-comparison-table td {
                padding: 0.65rem 0.65rem;
            }
            .th-asr, .th-trac {
                min-width: 110px;
            }
            .table-brand {
                font-size: 0.85rem;
            }
            .table-brand-sub {
                font-size: 0.6rem;
            }
        }
    </style>
    @yield('meta')
</head>
<body>
    <!-- NAVBAR -->
    <nav class="trvl-navbar" id="navbar">
        <div class="trvl-container" style="display:flex; justify-content:space-between; align-items:center; width:100%;">
            <a href="/" class="trvl-logo">
                <div class="trvl-logo-icon">
                    <svg class="w-5 h-5" fill="var(--trvl-blue)" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                </div>
                ASR GO
            </a>
            <div class="trvl-nav-links trvl-nav-links-desktop">
                <a href="{{ route('home') }}#layanan" class="trvl-nav-link">{{ __('nav.services') }}</a>
                <a href="{{ route('home') }}#keunggulan" class="trvl-nav-link">{{ __('nav.advantages') }}</a>
                <a href="{{ route('home') }}#rute" class="trvl-nav-link">{{ __('nav.popular_routes') }}</a>
                <a href="{{ route('home') }}#armada" class="trvl-nav-link">{{ __('nav.fleet') }}</a>
                <a href="{{ route('public.about.index') }}" class="trvl-nav-link">{{ __('nav.about') }}</a>
                <a href="{{ route('public.blog') }}" class="trvl-nav-link">{{ __('nav.blog') }}</a>
            </div>
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <!-- Language Switcher -->
                <a href="{{ route('lang.switch', ['locale' => app()->getLocale() === 'id' ? 'en' : 'id']) }}" 
                   class="trvl-nav-btn trvl-nav-btn-outline" 
                   style="display:flex; align-items:center; gap:4px; padding:0.5rem 0.75rem; font-size:0.85rem; font-weight:600; border-radius:var(--trvl-radius-sm); text-decoration:none; cursor:pointer; border:1.5px solid rgba(255,255,255,0.5); color:white;"
                   title="{{ app()->getLocale() === 'id' ? 'English' : 'Indonesia' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                </a>
                <button id="darkModeToggle" class="trvl-nav-btn trvl-nav-btn-outline" style="display:flex; align-items:center; justify-content:center; padding:0.5rem; border-radius:var(--trvl-radius-sm); background:transparent; cursor:pointer; border:1.5px solid rgba(255,255,255,0.5);" type="button" title="Toggle Dark Mode">
                    <svg id="sunIcon" class="hidden" width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    <svg id="moonIcon" width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </button>
                <a href="{{ route('login') }}" class="trvl-nav-btn trvl-nav-btn-outline">{{ __('nav.login') }}</a>
                <a href="tel:+6283156408078" class="trvl-nav-btn trvl-nav-btn-white inline-flex items-center gap-1.5" title="Hubungi Call Center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    {{ __('nav.call_center') }}
                </a>
                <button class="trvl-hamburger" style="display:none; flex-direction:column; gap:4px; background:none; border:none; cursor:pointer; padding:8px;" onclick="toggleMobileMenu()">
                    <span style="width:24px; height:2px; background:white; border-radius:2px;"></span>
                    <span style="width:24px; height:2px; background:white; border-radius:2px;"></span>
                    <span style="width:24px; height:2px; background:white; border-radius:2px;"></span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="trvl-mobile-menu" id="mobileMenu">
            <a href="{{ route('home') }}#layanan" onclick="toggleMobileMenu()">{{ __('nav.services') }}</a>
            <a href="{{ route('home') }}#keunggulan" onclick="toggleMobileMenu()">{{ __('nav.advantages') }}</a>
            <a href="{{ route('home') }}#rute" onclick="toggleMobileMenu()">{{ __('nav.popular_routes') }}</a>
            <a href="{{ route('home') }}#armada" onclick="toggleMobileMenu()">{{ __('nav.fleet') }}</a>
            <a href="{{ route('public.about.index') }}" onclick="toggleMobileMenu()">{{ __('nav.about') }}</a>
            <a href="{{ route('public.blog') }}" onclick="toggleMobileMenu()">{{ __('nav.blog') }}</a>
            <a href="{{ route('public.call-center') }}" onclick="toggleMobileMenu()">{{ __('nav.call_center') }}</a>
            <a href="{{ route('login') }}" onclick="toggleMobileMenu()">{{ __('nav.login') }}</a>
            <a href="{{ route('lang.switch', ['locale' => app()->getLocale() === 'id' ? 'en' : 'id']) }}" onclick="toggleMobileMenu()">{{ app()->getLocale() === 'id' ? 'English' : 'Indonesia' }}</a>
        </div>

    @yield('content')

    @hasSection('page-footer')
        @yield('page-footer')
    @else
    <footer class="trvl-footer py-12" style="background:#080f24;">
        <div class="trvl-container">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10">
                <div>
                    <p class="trvl-footer-brand mb-4">ASR <span>GO</span></p>
                    <p class="text-sm" style="color:#64748b;">{{ __('footer.description') }}</p>
                </div>
                <div>
                    <p class="trvl-footer-heading">{{ __('footer.services') }}</p>
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('public.travel') }}" class="trvl-footer-link">{{ __('footer.travel') }}</a>
                        <a href="{{ route('public.rental') }}" class="trvl-footer-link">{{ __('footer.rental') }}</a>
                        <a href="#" class="trvl-footer-link">{{ __('footer.airport') }}</a>
                    </div>
                </div>
                <div>
                    <p class="trvl-footer-heading">{{ __('footer.information') }}</p>
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('public.about.index') }}" class="trvl-footer-link">{{ __('footer.about') }}</a>
                        <a href="{{ route('public.blog') }}" class="trvl-footer-link">{{ __('footer.blog') }}</a>
                        <a href="{{ route('public.destinasi') }}" class="trvl-footer-link">{{ __('footer.destinations') }}</a>
                        <a href="{{ route('public.faq') }}" class="trvl-footer-link">{{ __('footer.faq') }}</a>
                        <a href="{{ route('syarat-ketentuan') }}" class="trvl-footer-link">{{ __('footer.terms') }}</a>
                        <a href="{{ route('public.kebijakan-privasi') }}" class="trvl-footer-link">{{ __('footer.privacy') }}</a>
                        <a href="{{ route('public.call-center') }}" class="trvl-footer-link">{{ __('nav.call_center') }}</a>
                    </div>
                </div>
                <div>
                    <p class="trvl-footer-heading">{{ __('footer.newsletter') }}</p>
                    <p class="text-sm mb-3" style="color:#64748b;">{{ __('footer.newsletter_desc') }}</p>
                    <form method="POST" action="{{ route('public.subscribe') }}" class="flex flex-col gap-2">
                        @csrf
                        <input type="email" name="email" placeholder="{{ __('footer.email_placeholder') }}" required
                               class="w-full px-3 py-2.5 rounded-lg text-sm border"
                               style="background:#1a1a3e; border-color:#2a2a4a; color:white; outline:none;">
                        <button type="submit"
                                class="w-full px-4 py-2.5 rounded-lg text-sm font-semibold transition-all"
                                style="background:var(--trvl-blue); color:white; border:none; cursor:pointer;">
                                {{ __('footer.subscribe') }}
                        </button>
                    </form>
                </div>
            </div>
            <div style="border-top:1px solid #1e293b; padding-top:2rem; text-align:center;">
                <p class="text-sm" style="color:#64748b;">&copy; {{ date('Y') }} ASR GO. All rights reserved.</p>
            </div>
        </div>
    </footer>
    @endif

    {{-- Toast Notifications --}}
    @if(session('success'))
        @include('components.toast', ['type' => 'success', 'message' => session('success')])
    @endif
    @if(session('error'))
        @include('components.toast', ['type' => 'error', 'message' => session('error')])
    @endif
    @if(session('warning'))
        @include('components.toast', ['type' => 'warning', 'message' => session('warning')])
    @endif
    @if(session('info'))
        @include('components.toast', ['type' => 'info', 'message' => session('info')])
    @endif

    <script>
    function toggleMobileMenu() {
        document.getElementById('mobileMenu').classList.toggle('open');
    }
    function switchTab(tab, btn) {
        document.querySelectorAll('.trvl-service-tab').forEach(t => { t.classList.remove('active'); t.classList.add('inactive'); });
        btn.classList.remove('inactive'); btn.classList.add('active');
        document.querySelectorAll('.trvl-booking-panel').forEach(p => p.classList.remove('active'));
        document.getElementById('panel-' + tab).classList.add('active');
    }
    // Scroll reveal
    document.addEventListener('scroll', function() {
        document.querySelectorAll('.trvl-reveal').forEach(el => {
            if (el.getBoundingClientRect().top < window.innerHeight - 50) el.classList.add('visible');
        });
    });
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const nav = document.getElementById('navbar');
        if (window.scrollY > 50) { nav.style.boxShadow = '0 4px 20px rgba(0,0,0,0.2)'; }
        else { nav.style.boxShadow = '0 2px 8px rgba(0,0,0,0.15)'; }
    });

    // Dark mode toggle
    (function () {
        const body = document.body;
        const sunIcon = document.getElementById('sunIcon');
        const moonIcon = document.getElementById('moonIcon');

        function applyDarkMode(enabled) {
            if (enabled) {
                body.classList.add('dark');
                sunIcon.classList.remove('hidden');
                moonIcon.classList.add('hidden');
            } else {
                body.classList.remove('dark');
                sunIcon.classList.add('hidden');
                moonIcon.classList.remove('hidden');
            }
            localStorage.setItem('darkMode', enabled ? '1' : '0');
        }

        const stored = localStorage.getItem('darkMode');
        applyDarkMode(stored === '1');

        document.getElementById('darkModeToggle').addEventListener('click', function () {
            applyDarkMode(!body.classList.contains('dark'));
        });
    })();
    </script>

<!-- CALL CENTER FLOATING BUTTON -->
<a href="tel:+6283156408078" 
   id="call-float"
   class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-blue-600 rounded-full flex items-center justify-center shadow-lg hover:bg-blue-700 transition-all hover:scale-110 group" title="Hubungi Call Center">
    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
    <span class="absolute right-full mr-3 bg-gray-900 text-white text-sm px-3 py-1.5 rounded-lg whitespace-nowrap opacity-0 group-hover:opacity-100 transition pointer-events-none">{{ __('nav.call_center') }}</span>
</a>

<!-- TOAST NOTIFICATION -->
<div id="toast-container" class="fixed top-20 right-4 z-50 space-y-2"></div>

<!-- BACK TO TOP -->
<button id="backToTop" onclick="window.scrollTo({top:0,behavior:'smooth'})" 
        class="fixed bottom-6 left-6 z-50 w-10 h-10 bg-blue-600 text-white rounded-full shadow-lg items-center justify-center hover:bg-blue-700 transition-all hidden">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
</button>

<script>
// Back to top visibility
window.addEventListener('scroll', () => {
    document.getElementById('backToTop').classList.toggle('hidden', window.scrollY < 500);
    document.getElementById('backToTop').classList.toggle('flex', window.scrollY >= 500);
});

// Toast notification system
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        info: 'bg-blue-500',
        warning: 'bg-yellow-500'
    };
    toast.className = `${colors[type]} text-white px-5 py-3 rounded-xl shadow-lg transform translate-x-full transition-all duration-300 flex items-center gap-2 max-w-sm`;
    toast.innerHTML = `<span>${message}</span>`;
    container.appendChild(toast);
    setTimeout(() => toast.classList.remove('translate-x-full'), 100);
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

// Lazy loading images
if ('IntersectionObserver' in window) {
    const imgObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                }
                imgObserver.unobserve(img);
            }
        });
    });
    document.querySelectorAll('img[loading="lazy"]').forEach(img => imgObserver.observe(img));
}

// Cross-page anchor handling
document.querySelectorAll('a[href*="#"]').forEach(link => {
    link.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        const hashIndex = href.indexOf('#');
        if (hashIndex === -1) return;
        const targetPath = href.substring(0, hashIndex);
        const hash = href.substring(hashIndex);
        
        // If link points to current page but with hash, smooth scroll
        if (!targetPath || targetPath === window.location.pathname || targetPath === window.location.pathname.replace(/\/$/, '')) {
            e.preventDefault();
            const el = document.querySelector(hash);
            if (el) {
                el.scrollIntoView({ behavior: 'smooth' });
            }
        }
        // Otherwise let browser navigate normally (route to home#section)
    });
});
</script>

</body>
</html>
