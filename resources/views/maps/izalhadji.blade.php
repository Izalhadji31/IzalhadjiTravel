@extends('layouts.app')

@section('title', 'Izalhadji Travel Maps')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Izalhadji Travel</h1>
        <p class="text-gray-600 mt-2">Tampilan peta & lokasi operasional (gaya seperti aplikasi rental mobil/Trac).</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left panel (Trac-like control card) -->
        <div class="lg:col-span-1">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5">
                <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Layanan</h2>
                <div class="mt-4 space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-blue-100 text-blue-700 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 21s-6-4.35-6-10a6 6 0 0 1 12 0c0 5.65-6 10-6 10z" />
                                <circle cx="12" cy="11" r="2" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">Pickup & Drop-off</div>
                            <div class="text-sm text-gray-600">Koordinasi jadwal titik jemput sesuai rute.</div>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-blue-100 text-blue-700 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">Monitoring Lokasi</div>
                            <div class="text-sm text-gray-600">Pantau area operasional & estimasi.</div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 border-t border-gray-200 pt-4">
                    <h3 class="text-sm font-semibold text-gray-700">Lokasi marker</h3>
                    <p class="text-sm text-gray-600 mt-2">
                        Marker default: <span class="font-semibold">Jakarta</span>.
                    </p>
                    <p class="text-xs text-gray-500 mt-2">
                        Anda bisa ganti koordinat/link di file ini.
                    </p>
                </div>

                <!-- Small search UI (visual only for now) -->
                <div class="mt-5">
                    <label class="block text-sm font-medium text-gray-700">Cari alamat / titik</label>
                    <input
                        type="text"
                        class="mt-2 w-full border border-gray-200 rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Contoh: Bandara Soekarno-Hatta"
                        disabled
                    />
                    <p class="text-xs text-gray-400 mt-2">(UI sementara) - embed map sudah tersedia.</p>
                </div>
            </div>
        </div>

        <!-- Map panel -->
        <div class="lg:col-span-2">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                    <div>
                        <div class="font-semibold text-gray-900">Peta Izalhadji Travel</div>
                        <div class="text-sm text-gray-600">Google Maps embed</div>
                    </div>
                    <a href="https://www.google.com/maps" target="_blank" rel="noopener" class="text-sm text-blue-600 hover:underline">Buka di Google Maps</a>
                </div>

                <!-- Default embed (Jakarta). Ganti dengan link maps izalhadji yang Anda miliki. -->
                <div class="w-full" style="height: 560px;">
                    <iframe
                        class="w-full h-full"
                        src="https://www.google.com/maps?q=-6.200000,106.816666&z=12&output=embed"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                    ></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

