<!DOCTYPE html>
<html lang="id">
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
            --trvl-bg: #1a1a2e;
            --trvl-text: #e0e0e0;
            --trvl-card: #16213e;
            --trvl-border: #2a2a4a;
            --trvl-gray-100: #1a1a2e;
            --trvl-gray-200: #2a2a4a;
            --trvl-gray-300: #3a3a5a;
            --trvl-gray-400: #5a5a7a;
            --trvl-gray-500: #8a8aaa;
            --trvl-gray-600: #aaaacc;
            --trvl-gray-700: #ccccee;
            --trvl-gray-800: #e0e0e0;
            --trvl-gray-900: #f0f0f0;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; }
        html { scroll-behavior: smooth; }
        body { background: var(--trvl-bg); color: var(--trvl-text); -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; transition: background 0.3s ease, color 0.3s ease; }

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
        .trvl-section-badge {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: var(--trvl-blue-light); color: var(--trvl-blue);
            padding: 0.35rem 1rem; border-radius: var(--trvl-radius-full);
            font-size: 0.78rem; font-weight: 700;
            border: 1px solid #dbeafe; margin-bottom: 0.875rem;
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
            font-size: 4rem; position: relative;
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
        .trvl-stat-card { text-align: center; padding: 2rem 1rem; }
        .trvl-stat-number { font-size: 2.4rem; font-weight: 900; color: var(--trvl-navy); line-height: 1; }
        .trvl-stat-label { font-size: 0.875rem; color: var(--trvl-gray-600); margin-top: 0.4rem; font-weight: 500; }

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
    </style>
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
                <a href="#layanan" class="trvl-nav-link">Layanan</a>
                <a href="#keunggulan" class="trvl-nav-link">Keunggulan</a>
                <a href="#rute" class="trvl-nav-link">Rute Populer</a>
                <a href="#armada" class="trvl-nav-link">Armada</a>
            </div>
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <button id="darkModeToggle" class="trvl-nav-btn trvl-nav-btn-outline" style="display:flex; align-items:center; justify-content:center; padding:0.5rem; border-radius:var(--trvl-radius-sm); background:transparent; cursor:pointer; border:1.5px solid rgba(255,255,255,0.5);" type="button" title="Toggle Dark Mode">
                    <svg id="sunIcon" class="hidden" width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    <svg id="moonIcon" width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </button>
                <a href="{{ route('login') }}" class="trvl-nav-btn trvl-nav-btn-outline">Masuk</a>
                <a href="https://wa.me/621500009" class="trvl-nav-btn trvl-nav-btn-white">📱 1500 009</a>
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
        <a href="#layanan" onclick="toggleMobileMenu()">Layanan</a>
        <a href="#keunggulan" onclick="toggleMobileMenu()">Keunggulan</a>
        <a href="#rute" onclick="toggleMobileMenu()">Rute Populer</a>
        <a href="#armada" onclick="toggleMobileMenu()">Armada</a>
        <a href="{{ route('login') }}" onclick="toggleMobileMenu()">Masuk</a>
    </div>

    @yield('content')

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
</body>
</html>
