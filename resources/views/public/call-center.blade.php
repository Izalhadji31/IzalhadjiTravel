@extends('layouts.public')

@section('title', 'Call Center - ASR GO')

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
                    Call Center
                </span>
            </h1>
            <p style="color: rgba(255,255,255,0.75); font-size: 0.9rem; margin-top: 0.25rem; font-weight: 400;">
                Kami siap membantu Anda 24/7
            </p>
        </div>
    </div>
</div>

<div style="background: var(--trvl-bg); padding: 2rem 0 4rem;">
    <div class="trvl-container">
        <div style="max-width: 900px; margin: 0 auto;">
            
            <!-- WhatsApp Contact -->
            <div style="background: var(--trvl-card); border-radius: var(--trvl-radius-lg); border: 1px solid var(--trvl-border); box-shadow: var(--trvl-shadow-sm); padding: 1.75rem; margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.25rem;">
                    <div style="width: 52px; height: 52px; border-radius: var(--trvl-radius-md); background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg class="w-6 h-6 text-green-600" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--trvl-gray-900);">WhatsApp</h3>
                        <p style="color: var(--trvl-gray-600); font-size: 0.9rem;">Respon cepat via chat WhatsApp</p>
                    </div>
                </div>
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <p style="font-size: 1.5rem; font-weight: 800; color: #25d366;">+62 831-5640-8078</p>
                        <p style="color: var(--trvl-gray-500); font-size: 0.8rem;">24 Jam — Setiap Hari</p>
                    </div>
                    <a href="https://wa.me/6283156408078?text=Halo%20ASR%20GO%2C%20saya%20ingin%20bertanya%20tentang%20layanan" 
                       target="_blank"
                       style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; background: #25d366; color: white; border-radius: var(--trvl-radius-md); font-weight: 700; font-size: 0.9rem; text-decoration: none; transition: all 0.2s; box-shadow: 0 4px 14px rgba(37,211,102,0.35);"
                       onmouseover="this.style.transform='translateY(-2px)'" 
                       onmouseout="this.style.transform='translateY(0)'">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Chat WhatsApp
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
                        <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--trvl-gray-900);">Jam Operasional</h3>
                        <p style="color: var(--trvl-gray-600); font-size: 0.9rem;">Kami siap melayani Anda</p>
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
                        <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--trvl-gray-900);">Form Kontak Cepat</h3>
                        <p style="color: var(--trvl-gray-600); font-size: 0.9rem;">Atau kirim pesan langsung melalui form di bawah</p>
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
