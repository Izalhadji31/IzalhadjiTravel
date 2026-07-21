@extends('layouts.public')

@section('title', __('call_center.title') . ' - ASR GO')

@section('content')
<style>
.call-center-hero {
    background: linear-gradient(135deg, #0d2147 0%, #1a3a6c 30%, #0064d2 70%, #1e88e5 100%);
}
.dark .call-center-hero {
    background: linear-gradient(135deg, #0a0a1a 0%, #0d1a3a 30%, #003d80 70%, #0d5ca0 100%);
}
</style>

<!-- HERO SECTION -->
<div class="call-center-hero" style="padding: 2.5rem 0 2rem;">
    <div class="trvl-container">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.75rem; font-weight: 800; color: white; letter-spacing: -0.5px;">
                <span style="display:inline-flex; align-items:center; gap:0.4rem;">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    {{ __('call_center.title') }}
                </span>
            </h1>
            <p style="color: rgba(255,255,255,0.75); font-size: 0.9rem; margin-top: 0.25rem; font-weight: 400;">
                {{ __('call_center.subtitle') }}
            </p>
        </div>
    </div>
</div>

<div style="background: var(--trvl-bg); padding: 2rem 0 4rem;">
    <div class="trvl-container">
        <div style="max-width: 900px; margin: 0 auto;">
            
            <!-- Call Center Contact (single unified contact) -->
            <div style="background: var(--trvl-card); border-radius: var(--trvl-radius-lg); border: 1px solid var(--trvl-border); box-shadow: var(--trvl-shadow-sm); padding: 1.75rem; margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.25rem;">
                    <div style="width: 52px; height: 52px; border-radius: var(--trvl-radius-md); background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <div>
                        <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--trvl-gray-900);">{{ __('call_center.contact_title') }}</h3>
                        <p style="color: var(--trvl-gray-600); font-size: 0.9rem;">{{ __('call_center.contact_desc') }}</p>
                    </div>
                </div>
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <p style="font-size: 1.5rem; font-weight: 800; color: #0064d2;">+62 831-5640-8078</p>
                        <p style="color: var(--trvl-gray-500); font-size: 0.8rem;">24 Jam — Setiap Hari</p>
                    </div>
                    <a href="tel:+6283156408078" 
                       style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; background: #0064d2; color: white; border-radius: var(--trvl-radius-md); font-weight: 700; font-size: 0.9rem; text-decoration: none; transition: all 0.2s; box-shadow: 0 4px 14px rgba(0,100,210,0.25);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        {{ __('call_center.button') }}
                    </a>
                </div>
            </div>

            <!-- Jam Operasional -->
            <div style="background: var(--trvl-card); border-radius: var(--trvl-radius-lg); border: 1px solid var(--trvl-border); box-shadow: var(--trvl-shadow-sm); padding: 1.75rem; margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.25rem;">
                    <div style="width: 52px; height: 52px; border-radius: var(--trvl-radius-md); background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--trvl-gray-900);">{{ __('call_center.operational_hours_title') }}</h3>
                        <p style="color: var(--trvl-gray-600); font-size: 0.9rem;">{{ __('call_center.operational_hours_desc') }}</p>
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--trvl-border);">
                        <span style="color: var(--trvl-gray-700); font-weight: 500; font-size: 0.9rem;">Senin - Jumat</span>
                        <span style="color: var(--trvl-gray-900); font-weight: 600; font-size: 0.9rem;">08:00 - 20:00</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--trvl-border);">
                        <span style="color: var(--trvl-gray-700); font-weight: 500; font-size: 0.9rem;">Sabtu</span>
                        <span style="color: var(--trvl-gray-900); font-weight: 600; font-size: 0.9rem;">08:00 - 18:00</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--trvl-border);">
                        <span style="color: var(--trvl-gray-700); font-weight: 500; font-size: 0.9rem;">Minggu & Hari Libur</span>
                        <span style="color: var(--trvl-gray-900); font-weight: 600; font-size: 0.9rem;">09:00 - 17:00</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 0.5rem 0;">
                        <span style="color: var(--trvl-gray-700); font-weight: 500; font-size: 0.9rem;">WhatsApp</span>
                        <span style="color: #25d366; font-weight: 700; font-size: 0.9rem;">24 Jam</span>
                    </div>
                </div>
            </div>

            <!-- Form Kontak Cepat -->
            <div style="background: var(--trvl-card); border-radius: var(--trvl-radius-lg); border: 1px solid var(--trvl-border); box-shadow: var(--trvl-shadow-sm); padding: 1.75rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.25rem;">
                    <div style="width: 52px; height: 52px; border-radius: var(--trvl-radius-md); background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--trvl-gray-900);">{{ __('call_center.quick_contact_title') }}</h3>
                        <p style="color: var(--trvl-gray-600); font-size: 0.9rem;">{{ __('call_center.quick_contact_desc') }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('public.contact.submit') }}">
                    @csrf
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div>
                            <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--trvl-gray-600); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.4rem;">Nama Lengkap</label>
                            <input type="text" name="name" required placeholder="Nama Anda"
                                   class="trvl-form-field">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--trvl-gray-600); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.4rem;">Email</label>
                            <input type="email" name="email" required placeholder="email@anda.com"
                                   class="trvl-form-field">
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div>
                            <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--trvl-gray-600); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.4rem;">Nomor Telepon</label>
                            <input type="tel" name="phone" required placeholder="08xxxxxxxxxx"
                                   class="trvl-form-field">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--trvl-gray-600); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.4rem;">Subjek</label>
                            <input type="text" name="subject" required placeholder="Subjek pesan"
                                   class="trvl-form-field">
                        </div>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--trvl-gray-600); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.4rem;">Pesan</label>
                        <textarea name="message" rows="4" required placeholder="Tulis pesan Anda di sini..."
                                  class="trvl-form-field" style="resize: vertical;"></textarea>
                    </div>
                    <button type="submit"
                            style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.875rem 2rem; background: linear-gradient(135deg, var(--trvl-blue) 0%, var(--trvl-blue-dark) 100%); color: white; border: none; border-radius: var(--trvl-radius-md); font-weight: 700; font-size: 0.9rem; cursor: pointer; transition: all 0.25s; box-shadow: 0 4px 16px rgba(0,100,210,0.38);"
                            onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 28px rgba(0,100,210,0.5)'"
                            onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 16px rgba(0,100,210,0.38)'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Kirim Pesan
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
