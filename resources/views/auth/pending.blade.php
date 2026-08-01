<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ app()->getLocale() === 'id' ? 'Status Akun' : 'Account Status' }} - ASR GO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-950 via-blue-900 to-blue-600 font-[Inter]">
    @php $locale = app()->getLocale(); @endphp
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="w-full max-w-2xl rounded-3xl border border-white/20 bg-white/95 p-8 text-center shadow-2xl shadow-slate-950/20 backdrop-blur">
            <div class="mb-8 flex items-center justify-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-200">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <span class="text-2xl font-bold text-slate-900"><span class="text-blue-600">ASR</span> GO</span>
            </div>

            @if (session('success'))
                <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-emerald-100 text-4xl">🎉</div>
                <h1 class="text-2xl font-bold text-slate-900">{{ $locale === 'id' ? 'Pendaftaran Berhasil!' : 'Registration Successful!' }}</h1>

                <div class="mt-6 flex items-center justify-center gap-3">
                    <div class="flex flex-col items-center">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-600 text-sm font-semibold text-white">✓</div>
                        <div class="mt-2 text-xs font-semibold text-blue-600">{{ $locale === 'id' ? 'Daftar' : 'Register' }}</div>
                    </div>
                    <div class="h-0.5 w-8 bg-blue-600"></div>
                    <div class="flex flex-col items-center">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-amber-500 text-sm font-semibold text-white">⏳</div>
                        <div class="mt-2 text-xs font-semibold text-amber-600">{{ $locale === 'id' ? 'Review Admin' : 'Admin Review' }}</div>
                    </div>
                    <div class="h-0.5 w-8 bg-slate-200"></div>
                    <div class="flex flex-col items-center">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-200 text-sm font-semibold text-slate-500">3</div>
                        <div class="mt-2 text-xs font-semibold text-slate-500">{{ $locale === 'id' ? 'Aktif' : 'Active' }}</div>
                    </div>
                </div>

                <p class="mt-6 text-sm leading-7 text-slate-600">{{ session('success') }}</p>

                <ul class="mt-6 space-y-3 rounded-2xl border border-slate-200 bg-slate-50 p-5 text-left text-sm text-slate-600">
                    <li class="flex gap-2"><span>📧</span><span>{{ $locale === 'id' ? 'Cek inbox email Anda untuk notifikasi persetujuan.' : 'Check your email inbox for an approval notification.' }}</span></li>
                    <li class="flex gap-2"><span>⏱️</span><span>{{ $locale === 'id' ? 'Proses review biasanya membutuhkan 1×24 jam.' : 'The review process usually takes up to 24 hours.' }}</span></li>
                    <li class="flex gap-2"><span>📞</span><span>{{ $locale === 'id' ? 'Hubungi WhatsApp kami jika perlu bantuan.' : 'Contact our WhatsApp if you need assistance.' }}</span></li>
                </ul>

            @elseif (session('info'))
                <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-amber-100 text-4xl">⏳</div>
                <h1 class="text-2xl font-bold text-slate-900">{{ $locale === 'id' ? 'Akun Sedang Ditinjau' : 'Account Under Review' }}</h1>

                <div class="mt-6 flex items-center justify-center gap-3">
                    <div class="flex flex-col items-center">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-600 text-sm font-semibold text-white">✓</div>
                        <div class="mt-2 text-xs font-semibold text-blue-600">{{ $locale === 'id' ? 'Daftar' : 'Register' }}</div>
                    </div>
                    <div class="h-0.5 w-8 bg-blue-600"></div>
                    <div class="flex flex-col items-center">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-amber-500 text-sm font-semibold text-white">⏳</div>
                        <div class="mt-2 text-xs font-semibold text-amber-600">{{ $locale === 'id' ? 'Review Admin' : 'Admin Review' }}</div>
                    </div>
                    <div class="h-0.5 w-8 bg-slate-200"></div>
                    <div class="flex flex-col items-center">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-200 text-sm font-semibold text-slate-500">3</div>
                        <div class="mt-2 text-xs font-semibold text-slate-500">{{ $locale === 'id' ? 'Aktif' : 'Active' }}</div>
                    </div>
                </div>

                <p class="mt-6 text-sm leading-7 text-slate-600">{{ session('info') }}</p>

            @elseif (session('error'))
                <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-red-100 text-4xl">❌</div>
                <h1 class="text-2xl font-bold text-slate-900">{{ $locale === 'id' ? 'Akun Ditolak' : 'Account Rejected' }}</h1>
                <p class="mt-6 text-sm leading-7 text-slate-600">{{ session('error') }}</p>
                <ul class="mt-6 space-y-3 rounded-2xl border border-slate-200 bg-slate-50 p-5 text-left text-sm text-slate-600">
                    <li class="flex gap-2"><span>💬</span><span>{{ $locale === 'id' ? 'Hubungi tim kami melalui WhatsApp untuk informasi lebih lanjut.' : 'Contact our team via WhatsApp for more information.' }}</span></li>
                </ul>

            @else
                <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-amber-100 text-4xl">⏳</div>
                <h1 class="text-2xl font-bold text-slate-900">{{ $locale === 'id' ? 'Status Akun' : 'Account Status' }}</h1>
                <p class="mt-6 text-sm leading-7 text-slate-600">
                    {{ $locale === 'id'
                        ? 'Akun Anda sedang dalam proses peninjauan oleh admin ASR GO.'
                        : 'Your account is currently being reviewed by the ASR GO admin team.' }}
                </p>
            @endif

            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('login') }}" class="inline-flex items-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700">
                    {{ $locale === 'id' ? '← Kembali ke Masuk' : '← Back to Login' }}
                </a>
                <a href="tel:+6283156408078" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-400 hover:bg-slate-50">
                    📞 Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</body>
</html>
