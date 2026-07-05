@extends('layouts.public')

@section('title', 'Tentang Kami - ASR GO')

@section('content')
<style>
.travel-hero-section {
    background: linear-gradient(135deg, #0d2147 0%, #1a3a6c 30%, #0064d2 70%, #1e88e5 100%);
}
.dark .travel-hero-section {
    background: linear-gradient(135deg, #0a0a1a 0%, #0d1a3a 30%, #003d80 70%, #0d5ca0 100%);
}
</style>
<!-- HERO SECTION -->
<div class="travel-hero-section" style="padding: 2.5rem 0 2rem;">
    <div class="trvl-container">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.75rem; font-weight: 800; color: white; letter-spacing: -0.5px;">
                <span style="display:inline-flex; align-items:center; gap:0.4rem;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                    Tentang Kami
                </span>
            </h1>
            <p style="color: rgba(255,255,255,0.75); font-size: 0.9rem; margin-top: 0.25rem; font-weight: 400;">Layanan Transportasi Terpercaya di Pulau Flores</p>
        </div>
    </div>
</div>

<div style="background: var(--trvl-bg); padding: 2rem 0 4rem;">
    <div class="trvl-container">
        <div style="max-width: 1000px; margin: 0 auto;">
            <!-- Company Profile -->
            <div style="margin-bottom: 2.5rem;">
                <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--trvl-gray-900); margin-bottom: 1.25rem;">Profil Perusahaan</h2>
                <div style="background: var(--trvl-card); border-radius: var(--trvl-radius-lg); border: 1px solid var(--trvl-border); box-shadow: var(--trvl-shadow-sm); padding: 1.75rem;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                        <div>
                            <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--trvl-gray-900); margin-bottom: 1rem;">CV. Izalhadji Travel</h3>
                            <p style="color: var(--trvl-gray-700); line-height: 1.7; margin-bottom: 1rem; font-size: 0.9rem;">
                                Kami adalah perusahaan transportasi yang berpusat di Ende, Pulau Flores, Indonesia. 
                                Sejak didirikan, kami berkomitmen untuk memberikan layanan transportasi terbaik dengan 
                                harga yang terjangkau dan profesional.
                            </p>
                            <p style="color: var(--trvl-gray-700); line-height: 1.7; margin-bottom: 1rem; font-size: 0.9rem;">
                                ASR GO menawarkan dua layanan utama: Travel Antar Kota dan Sewa Kendaraan. 
                                Dengan armada modern dan driver berpengalaman, kami siap mengantarkan Anda ke destinasi 
                                dengan aman dan nyaman.
                            </p>
                            <p style="color: var(--trvl-gray-700); line-height: 1.7; font-size: 0.9rem;">
                                Kepercayaan pelanggan adalah prioritas utama kami. Oleh karena itu, kami terus berinovasi 
                                dan meningkatkan kualitas layanan untuk memenuhi harapan Anda.
                            </p>
                        </div>
                        <div>
                            <div style="background: linear-gradient(135deg, #e8f4fd 0%, #f0f6ff 100%); border-radius: var(--trvl-radius-lg); padding: 2rem 1.5rem; height: 100%; display: flex; align-items: center; justify-content: center;">
                                <div style="text-align: center;">
                                    <div style="font-size: 3rem; font-weight: 900; color: var(--trvl-blue); margin-bottom: 0.5rem;">ASR</div>
                                    <p style="color: var(--trvl-gray-600); font-weight: 700;">GO</p>
                                    <p style="font-size: 0.85rem; color: var(--trvl-gray-500); margin-top: 1rem;">Transportasi Terpercaya</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vision & Mission -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2.5rem;">
                <!-- Vision -->
                <div style="background: var(--trvl-card); border-radius: var(--trvl-radius-lg); border: 1px solid var(--trvl-border); box-shadow: var(--trvl-shadow-sm); padding: 1.75rem;">
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.25rem;">
                        <div style="width: 48px; height: 48px; border-radius: var(--trvl-radius-md); background: linear-gradient(135deg, #e8f4fd 0%, #f0f6ff 100%); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--trvl-blue)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                        </div>
                        <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--trvl-gray-900);">Visi Kami</h3>
                    </div>
                    <p style="color: var(--trvl-gray-700); line-height: 1.7; font-size: 0.9rem;">
                        Menjadi layanan transportasi terdepan di Pulau Flores yang dipercaya oleh jutaan pelanggan 
                        dengan memberikan pengalaman perjalanan yang nyaman, aman, dan terjangkau.
                    </p>
                </div>

                <!-- Mission -->
                <div style="background: var(--trvl-card); border-radius: var(--trvl-radius-lg); border: 1px solid var(--trvl-border); box-shadow: var(--trvl-shadow-sm); padding: 1.75rem;">
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.25rem;">
                        <div style="width: 48px; height: 48px; border-radius: var(--trvl-radius-md); background: linear-gradient(135deg, #e8f4fd 0%, #f0f6ff 100%); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--trvl-blue)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                        </div>
                        <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--trvl-gray-900);">Misi Kami</h3>
                    </div>
                    <ul style="display: flex; flex-direction: column; gap: 0.65rem;">
                        <li style="display: flex; align-items: flex-start; gap: 0.5rem;">
                            <span style="color: #00a651; font-weight: 700; flex-shrink: 0;">✓</span>
                            <span style="color: var(--trvl-gray-700); font-size: 0.9rem;">Menyediakan layanan transportasi berkualitas tinggi</span>
                        </li>
                        <li style="display: flex; align-items: flex-start; gap: 0.5rem;">
                            <span style="color: #00a651; font-weight: 700; flex-shrink: 0;">✓</span>
                            <span style="color: var(--trvl-gray-700); font-size: 0.9rem;">Menjaga kepuasan dan keselamatan pelanggan</span>
                        </li>
                        <li style="display: flex; align-items: flex-start; gap: 0.5rem;">
                            <span style="color: #00a651; font-weight: 700; flex-shrink: 0;">✓</span>
                            <span style="color: var(--trvl-gray-700); font-size: 0.9rem;">Memberikan harga yang kompetitif dan transparan</span>
                        </li>
                        <li style="display: flex; align-items: flex-start; gap: 0.5rem;">
                            <span style="color: #00a651; font-weight: 700; flex-shrink: 0;">✓</span>
                            <span style="color: var(--trvl-gray-700); font-size: 0.9rem;">Terus berinovasi dan berkembang</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Values -->
            <div style="background: var(--trvl-card); border-radius: var(--trvl-radius-lg); border: 1px solid var(--trvl-border); box-shadow: var(--trvl-shadow-sm); padding: 1.75rem; margin-bottom: 2.5rem;">
                <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--trvl-gray-900); margin-bottom: 1.5rem;">Nilai-Nilai Kami</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.25rem;">
                    <div style="text-align: center; padding: 1rem;">
                        <div style="font-size: 2.5rem; margin-bottom: 0.75rem;">🤝</div>
                        <h3 style="font-size: 1rem; font-weight: 700; color: var(--trvl-gray-900); margin-bottom: 0.5rem;">Integritas</h3>
                        <p style="font-size: 0.85rem; color: var(--trvl-gray-600);">Jujur dan terpercaya dalam setiap transaksi</p>
                    </div>
                    <div style="text-align: center; padding: 1rem;">
                        <div style="font-size: 2.5rem; margin-bottom: 0.75rem;">⭐</div>
                        <h3 style="font-size: 1rem; font-weight: 700; color: var(--trvl-gray-900); margin-bottom: 0.5rem;">Kualitas</h3>
                        <p style="font-size: 0.85rem; color: var(--trvl-gray-600);">Memberikan yang terbaik untuk pelanggan</p>
                    </div>
                    <div style="text-align: center; padding: 1rem;">
                        <div style="font-size: 2.5rem; margin-bottom: 0.75rem;">🚀</div>
                        <h3 style="font-size: 1rem; font-weight: 700; color: var(--trvl-gray-900); margin-bottom: 0.5rem;">Inovasi</h3>
                        <p style="font-size: 0.85rem; color: var(--trvl-gray-600);">Selalu mencari cara baru untuk berkembang</p>
                    </div>
                    <div style="text-align: center; padding: 1rem;">
                        <div style="font-size: 2.5rem; margin-bottom: 0.75rem;">❤️</div>
                        <h3 style="font-size: 1rem; font-weight: 700; color: var(--trvl-gray-900); margin-bottom: 0.5rem;">Kepedulian</h3>
                        <p style="font-size: 0.85rem; color: var(--trvl-gray-600);">Peduli terhadap pelanggan dan masyarakat</p>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div style="background: var(--trvl-card); border: 1px solid var(--trvl-border); border-radius: var(--trvl-radius-lg); overflow: hidden;">
                <div style="display: grid; grid-template-columns: repeat(4, 1fr);">
                    <div style="text-align: center; padding: 2rem 1rem; border-right: 1px solid var(--trvl-border);">
                        <p style="font-size: 2.4rem; font-weight: 900; color: var(--trvl-blue); line-height: 1; margin-bottom: 0.4rem;">2010</p>
                        <p style="font-size: 0.875rem; color: var(--trvl-gray-600); font-weight: 500;">Tahun Berdiri</p>
                    </div>
                    <div style="text-align: center; padding: 2rem 1rem; border-right: 1px solid var(--trvl-border);">
                        <p style="font-size: 2.4rem; font-weight: 900; color: var(--trvl-blue); line-height: 1; margin-bottom: 0.4rem;">50+</p>
                        <p style="font-size: 0.875rem; color: var(--trvl-gray-600); font-weight: 500;">Kendaraan Armada</p>
                    </div>
                    <div style="text-align: center; padding: 2rem 1rem; border-right: 1px solid var(--trvl-border);">
                        <p style="font-size: 2.4rem; font-weight: 900; color: var(--trvl-blue); line-height: 1; margin-bottom: 0.4rem;">100K+</p>
                        <p style="font-size: 0.875rem; color: var(--trvl-gray-600); font-weight: 500;">Pelanggan Puas</p>
                    </div>
                    <div style="text-align: center; padding: 2rem 1rem;">
                        <p style="font-size: 2.4rem; font-weight: 900; color: var(--trvl-blue); line-height: 1; margin-bottom: 0.4rem;">24/7</p>
                        <p style="font-size: 0.875rem; color: var(--trvl-gray-600); font-weight: 500;">Layanan Pelanggan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
