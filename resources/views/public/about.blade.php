@extends('layouts.public')

@section('title', __('about.title') . ' - ASR GO')

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
                    {{ __('about.title') }}
                </span>
            </h1>
            <p style="color: rgba(255,255,255,0.75); font-size: 0.9rem; margin-top: 0.25rem; font-weight: 400;">{{ __('about.subtitle') }}</p>
        </div>
    </div>
</div>

<div style="background: var(--trvl-bg); padding: 2rem 0 4rem;">
    <div class="trvl-container">
        <div style="max-width: 1000px; margin: 0 auto;">
            <!-- Company Profile -->
            <div style="margin-bottom: 2.5rem;">
                <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--trvl-gray-900); margin-bottom: 1.25rem;">{{ __('about.profile_title') }}</h2>
                <div style="background: var(--trvl-card); border-radius: var(--trvl-radius-lg); border: 1px solid var(--trvl-border); box-shadow: var(--trvl-shadow-sm); padding: 1.75rem;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                        <div>
                            <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--trvl-gray-900); margin-bottom: 1rem;">{{ __('about.company_name') }}</h3>
                            <p style="color: var(--trvl-gray-700); line-height: 1.7; margin-bottom: 1rem; font-size: 0.9rem;">
                                {{ __('about.profile_desc_1') }}
                            </p>
                            <p style="color: var(--trvl-gray-700); line-height: 1.7; margin-bottom: 1rem; font-size: 0.9rem;">
                                {{ __('about.profile_desc_2') }}
                            </p>
                            <p style="color: var(--trvl-gray-700); line-height: 1.7; font-size: 0.9rem;">
                                {{ __('about.profile_desc_3') }}
                            </p>
                        </div>
                        <div>
                            <div style="background: linear-gradient(135deg, #e8f4fd 0%, #f0f6ff 100%); border-radius: var(--trvl-radius-lg); padding: 2rem 1.5rem; height: 100%; display: flex; align-items: center; justify-content: center;">
                                <div style="text-align: center;">
                                    <div style="font-size: 3rem; font-weight: 900; color: var(--trvl-blue); margin-bottom: 0.5rem;">ASR</div>
                                    <p style="color: var(--trvl-gray-600); font-weight: 700;">GO</p>
                                    <p style="font-size: 0.85rem; color: var(--trvl-gray-500); margin-top: 1rem;">{{ __('about.transport_tagline') }}</p>
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
                        <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--trvl-gray-900);">{{ __('about.vision_title') }}</h3>
                    </div>
                    <p style="color: var(--trvl-gray-700); line-height: 1.7; font-size: 0.9rem;">
                        {{ __('about.vision_desc') }}
                    </p>
                </div>

                <!-- Mission -->
                <div style="background: var(--trvl-card); border-radius: var(--trvl-radius-lg); border: 1px solid var(--trvl-border); box-shadow: var(--trvl-shadow-sm); padding: 1.75rem;">
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.25rem;">
                        <div style="width: 48px; height: 48px; border-radius: var(--trvl-radius-md); background: linear-gradient(135deg, #e8f4fd 0%, #f0f6ff 100%); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--trvl-blue)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                        </div>
                        <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--trvl-gray-900);">{{ __('about.mission_title') }}</h3>
                    </div>
                    <ul style="display: flex; flex-direction: column; gap: 0.65rem;">
                        <li style="display: flex; align-items: flex-start; gap: 0.5rem;">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span style="color: var(--trvl-gray-700); font-size: 0.9rem;">{{ __('about.mission_1') }}</span>
                        </li>
                        <li style="display: flex; align-items: flex-start; gap: 0.5rem;">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span style="color: var(--trvl-gray-700); font-size: 0.9rem;">{{ __('about.mission_2') }}</span>
                        </li>
                        <li style="display: flex; align-items: flex-start; gap: 0.5rem;">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span style="color: var(--trvl-gray-700); font-size: 0.9rem;">{{ __('about.mission_3') }}</span>
                        </li>
                        <li style="display: flex; align-items: flex-start; gap: 0.5rem;">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span style="color: var(--trvl-gray-700); font-size: 0.9rem;">{{ __('about.mission_4') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Values -->
            <div style="background: var(--trvl-card); border-radius: var(--trvl-radius-lg); border: 1px solid var(--trvl-border); box-shadow: var(--trvl-shadow-sm); padding: 1.75rem; margin-bottom: 2.5rem;">
                <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--trvl-gray-900); margin-bottom: 1.5rem;">{{ __('about.values_title') }}</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.25rem;">
                    <div style="text-align: center; padding: 1rem;">
                        <div style="width: 48px; height: 48px; border-radius: var(--trvl-radius-md); background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%); display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem;">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h3 style="font-size: 1rem; font-weight: 700; color: var(--trvl-gray-900); margin-bottom: 0.5rem;">{{ __('about.value_integrity') }}</h3>
                        <p style="font-size: 0.85rem; color: var(--trvl-gray-600);">{{ __('about.value_integrity_desc') }}</p>
                    </div>
                    <div style="text-align: center; padding: 1rem;">
                        <div style="width: 48px; height: 48px; border-radius: var(--trvl-radius-md); background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem;">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        </div>
                        <h3 style="font-size: 1rem; font-weight: 700; color: var(--trvl-gray-900); margin-bottom: 0.5rem;">{{ __('about.value_quality') }}</h3>
                        <p style="font-size: 0.85rem; color: var(--trvl-gray-600);">{{ __('about.value_quality_desc') }}</p>
                    </div>
                    <div style="text-align: center; padding: 1rem;">
                        <div style="width: 48px; height: 48px; border-radius: var(--trvl-radius-md); background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%); display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem;">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <h3 style="font-size: 1rem; font-weight: 700; color: var(--trvl-gray-900); margin-bottom: 0.5rem;">{{ __('about.value_innovation') }}</h3>
                        <p style="font-size: 0.85rem; color: var(--trvl-gray-600);">{{ __('about.value_innovation_desc') }}</p>
                    </div>
                    <div style="text-align: center; padding: 1rem;">
                        <div style="width: 48px; height: 48px; border-radius: var(--trvl-radius-md); background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%); display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem;">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </div>
                        <h3 style="font-size: 1rem; font-weight: 700; color: var(--trvl-gray-900); margin-bottom: 0.5rem;">{{ __('about.value_care') }}</h3>
                        <p style="font-size: 0.85rem; color: var(--trvl-gray-600);">{{ __('about.value_care_desc') }}</p>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div style="background: var(--trvl-card); border: 1px solid var(--trvl-border); border-radius: var(--trvl-radius-lg); overflow: hidden;">
                <div style="display: grid; grid-template-columns: repeat(4, 1fr);">
                    <div style="text-align: center; padding: 2rem 1rem; border-right: 1px solid var(--trvl-border);">
                        <p style="font-size: 2.4rem; font-weight: 900; color: var(--trvl-blue); line-height: 1; margin-bottom: 0.4rem;">2010</p>
                        <p style="font-size: 0.875rem; color: var(--trvl-gray-600); font-weight: 500;">{{ __('about.stat_founded') }}</p>
                    </div>
                    <div style="text-align: center; padding: 2rem 1rem; border-right: 1px solid var(--trvl-border);">
                        <p style="font-size: 2.4rem; font-weight: 900; color: var(--trvl-blue); line-height: 1; margin-bottom: 0.4rem;">50+</p>
                        <p style="font-size: 0.875rem; color: var(--trvl-gray-600); font-weight: 500;">{{ __('about.stat_fleet') }}</p>
                    </div>
                    <div style="text-align: center; padding: 2rem 1rem; border-right: 1px solid var(--trvl-border);">
                        <p style="font-size: 2.4rem; font-weight: 900; color: var(--trvl-blue); line-height: 1; margin-bottom: 0.4rem;">100K+</p>
                        <p style="font-size: 0.875rem; color: var(--trvl-gray-600); font-weight: 500;">{{ __('about.stat_customers') }}</p>
                    </div>
                    <div style="text-align: center; padding: 2rem 1rem;">
                        <p style="font-size: 2.4rem; font-weight: 900; color: var(--trvl-blue); line-height: 1; margin-bottom: 0.4rem;">24/7</p>
                        <p style="font-size: 0.875rem; color: var(--trvl-gray-600); font-weight: 500;">{{ __('about.stat_support') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
