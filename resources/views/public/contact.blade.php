@extends('layouts.public')

@section('title', 'Kontak - ASR GO')

@section('content')
<!-- HERO SECTION -->
<div class="travel-hero-section" style="padding: 2.5rem 0 2rem;">
    <div class="trvl-container">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.75rem; font-weight: 800; color: white; letter-spacing: -0.5px;">
                <span style="display:inline-flex; align-items:center; gap:0.4rem;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Hubungi Kami
                </span>
            </h1>
            <p style="color: rgba(255,255,255,0.75); font-size: 0.9rem; margin-top: 0.25rem; font-weight: 400;">Kami siap membantu Anda 24/7</p>
        </div>
    </div>
</div>

<!-- MAIN CONTENT -->
<div style="background: var(--trvl-bg); padding: 2rem 0 4rem;">
    <div class="trvl-container">
        <div style="max-width: 1100px; margin: 0 auto;">

            <!-- Contact Info Cards -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.25rem; margin-bottom: 2.5rem;">
                <!-- WhatsApp Card -->
                <div style="background: var(--trvl-card); border-radius: var(--trvl-radius-lg); border: 1px solid var(--trvl-border); box-shadow: var(--trvl-shadow-sm); padding: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #e8f4fd 0%, #f0f6ff 100%); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--trvl-blue)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"></path></svg>
                        </div>
                        <h3 style="font-size: 1rem; font-weight: 700; color: var(--trvl-gray-900);">WhatsApp</h3>
                    </div>
                    <p style="font-size: 0.85rem; color: var(--trvl-gray-600); margin-bottom: 1rem; line-height: 1.5;">Hubungi kami melalui WhatsApp untuk respons cepat</p>
                    <a href="https://wa.me/6283156408078?text=Halo%20ASR%20GO" 
                       target="_blank"
                       style="display: inline-flex; align-items: center; gap: 0.5rem; color: #00a651; font-weight: 700; font-size: 0.9rem; text-decoration: none; transition: all 0.2s;">
                        (+62)831-5640-8078
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#00a651" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                </div>

                <!-- Email Card -->
                <div style="background: var(--trvl-card); border-radius: var(--trvl-radius-lg); border: 1px solid var(--trvl-border); box-shadow: var(--trvl-shadow-sm); padding: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #e8f4fd 0%, #f0f6ff 100%); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--trvl-blue)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7l-10 7L2 7"/></svg>
                        </div>
                        <h3 style="font-size: 1rem; font-weight: 700; color: var(--trvl-gray-900);">Email</h3>
                    </div>
                    <p style="font-size: 0.85rem; color: var(--trvl-gray-600); margin-bottom: 1rem; line-height: 1.5;">Kirimkan pertanyaan melalui email</p>
                    <a href="mailto:info@asrgo.id" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--trvl-blue); font-weight: 700; font-size: 0.9rem; text-decoration: none; word-break: break-all; transition: all 0.2s;">
                        info@asrgo.id
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--trvl-blue)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                </div>

                <!-- Office Card -->
                <div style="background: var(--trvl-card); border-radius: var(--trvl-radius-lg); border: 1px solid var(--trvl-border); box-shadow: var(--trvl-shadow-sm); padding: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #e8f4fd 0%, #f0f6ff 100%); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--trvl-blue)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <h3 style="font-size: 1rem; font-weight: 700; color: var(--trvl-gray-900);">Kantor</h3>
                    </div>
                    <p style="font-size: 0.85rem; color: var(--trvl-gray-600); margin-bottom: 1rem; line-height: 1.5;">Kunjungi kantor kami langsung</p>
                    <p style="font-size: 0.9rem; font-weight: 600; color: var(--trvl-gray-800); line-height: 1.6;">
                        Jl. Veteran No. 45<br>
                        Ende, Flores 86312<br>
                        NTT, Indonesia
                    </p>
                </div>
            </div>

            <!-- Contact Form & Map -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <!-- Contact Form -->
                <div style="background: var(--trvl-card); border-radius: var(--trvl-radius-lg); border: 1px solid var(--trvl-border); box-shadow: var(--trvl-shadow-sm); padding: 1.75rem;">
                    <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--trvl-gray-900); margin-bottom: 1.5rem;">Kirim Pesan</h2>

                    @if (session('success'))
                        <div style="margin-bottom: 1.25rem; padding: 0.875rem 1rem; background: rgba(0,166,81,0.08); border: 1px solid rgba(0,166,81,0.2); border-radius: var(--trvl-radius-md);">
                            <p style="color: #00a651; font-weight: 600; font-size: 0.875rem;">{{ session('success') }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('public.contact.submit') }}" style="display: flex; flex-direction: column; gap: 1.25rem;">
                        @csrf

                        <div>
                            <label class="trvl-field-label">Nama</label>
                            <input type="text" name="name" required 
                                   class="trvl-form-field @error('name') border-red-500 @enderror"
                                   placeholder="Nama lengkap Anda"
                                   value="{{ old('name') }}"
                                   style="background: var(--trvl-bg);">
                            @error('name')
                                <p style="color: #e53935; font-size: 0.78rem; margin-top: 0.3rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="trvl-field-label">Email</label>
                            <input type="email" name="email" required 
                                   class="trvl-form-field @error('email') border-red-500 @enderror"
                                   placeholder="email@contoh.com"
                                   value="{{ old('email') }}"
                                   style="background: var(--trvl-bg);">
                            @error('email')
                                <p style="color: #e53935; font-size: 0.78rem; margin-top: 0.3rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="trvl-field-label">Nomor Telepon</label>
                            <input type="tel" name="phone" required 
                                   class="trvl-form-field @error('phone') border-red-500 @enderror"
                                   placeholder="08xxxxxxxxxx"
                                   value="{{ old('phone') }}"
                                   style="background: var(--trvl-bg);">
                            @error('phone')
                                <p style="color: #e53935; font-size: 0.78rem; margin-top: 0.3rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="trvl-field-label">Subjek</label>
                            <input type="text" name="subject" required 
                                   class="trvl-form-field @error('subject') border-red-500 @enderror"
                                   placeholder="Topik pertanyaan Anda"
                                   value="{{ old('subject') }}"
                                   style="background: var(--trvl-bg);">
                            @error('subject')
                                <p style="color: #e53935; font-size: 0.78rem; margin-top: 0.3rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="trvl-field-label">Pesan</label>
                            <textarea name="message" required rows="5"
                                      class="trvl-form-field @error('message') border-red-500 @enderror"
                                      placeholder="Tulis pesan Anda di sini..."
                                      style="background: var(--trvl-bg); resize: vertical;">{{ old('message') }}</textarea>
                            @error('message')
                                <p style="color: #e53935; font-size: 0.78rem; margin-top: 0.3rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="trvl-btn-search" style="width: 100%; justify-content: center;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                            Kirim Pesan
                        </button>
                    </form>
                </div>

                <!-- Map -->
                <div style="background: var(--trvl-card); border-radius: var(--trvl-radius-lg); border: 1px solid var(--trvl-border); box-shadow: var(--trvl-shadow-sm); padding: 1.75rem;">
                    <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--trvl-gray-900); margin-bottom: 1.5rem;">Lokasi Kami</h2>
                    <div style="width: 100%; height: 280px; border-radius: var(--trvl-radius-md); overflow: hidden; border: 1px solid var(--trvl-border);">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3945.2479999999997!2d121.67384!3d-8.833333!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c3c3c3c3c3c3c3d%3A0x0!2sEnde%2C%20East%20Nusa%20Tenggara!5e0!3m2!1sen!2sid!4v1234567890"
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div style="margin-top: 1.25rem; padding: 1rem 1.125rem; background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%); border: 1px solid #dbeafe; border-radius: var(--trvl-radius-md);">
                        <p style="font-size: 0.82rem; color: var(--trvl-gray-700); margin-bottom: 0.5rem;">
                            <strong>Jam Operasional:</strong>
                        </p>
                        <p style="font-size: 0.82rem; color: var(--trvl-gray-600);">Senin - Minggu: 06:00 - 22:00 WIT</p>
                        <p style="font-size: 0.82rem; color: var(--trvl-gray-600);">Pelayanan darurat tersedia 24 jam</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Hero section matching public layout */
.travel-hero-section {
    background: linear-gradient(135deg, #0d2147 0%, #1a3a6c 30%, #0064d2 70%, #1e88e5 100%);
}
.dark .travel-hero-section {
    background: linear-gradient(135deg, #0a0a1a 0%, #0d1a3a 30%, #003d80 70%, #0d5ca0 100%);
}
.dark .trvl-info-panel-custom {
    background: rgba(59, 130, 246, 0.16) !important;
    border-color: rgba(96, 165, 250, 0.28) !important;
    color: #dbeafe;
}
@media (max-width: 768px) {
    div[style*="grid-template-columns: 1fr 1fr"]:last-child {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection
