@extends('layouts.public')

@section('title', __('privasi.title') . ' - ASR GO')

@section('content')
<div class="bg-white py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-2">{{ __('privasi.title') }}</h1>
        <p class="text-gray-500 mb-8">{{ __('privasi.last_updated') }}</p>
        
        <div class="prose prose-gray max-w-none space-y-6 text-gray-700">
            <section>
                <h2 class="text-xl font-bold text-gray-900 border-b pb-2">{{ __('privasi.section_1') }}</h2>
                <p>ASR GO ("kami") menghargai privasi Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda saat menggunakan layanan kami.</p>
            </section>
            
            <section>
                <h2 class="text-xl font-bold text-gray-900 border-b pb-2">{{ __('privasi.section_2') }}</h2>
                <ul class="list-disc pl-5 space-y-2">
                    <li><strong>Data Pribadi:</strong> Nama, email, nomor telepon, alamat, foto KTP/SIM (untuk rental)</li>
                    <li><strong>Data Pembayaran:</strong> Informasi diproses oleh payment gateway Midtrans (kami tidak menyimpan data kartu kredit)</li>
                    <li><strong>Data Penggunaan:</strong> Riwayat pemesanan, preferensi rute, interaksi dengan website</li>
                    <li><strong>Data Lokasi:</strong> GPS tracking selama perjalanan (untuk keamanan)</li>
                    <li><strong>Data Perangkat:</strong> IP address, browser type, device identifier</li>
                </ul>
            </section>
            
            <section>
                <h2 class="text-xl font-bold text-gray-900 border-b pb-2">{{ __('privasi.section_3') }}</h2>
                <p>Kami menggunakan informasi untuk:</p>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Memproses dan mengelola pemesanan Anda</li>
                    <li>Mengirim konfirmasi dan notifikasi perjalanan</li>
                    <li>Menyediakan layanan customer support</li>
                    <li>Meningkatkan kualitas layanan dan pengalaman pengguna</li>
                    <li>Analisis dan pengembangan produk</li>
                    <li>Marketing dan promosi (dengan persetujuan Anda)</li>
                </ul>
            </section>
            
            <section>
                <h2 class="text-xl font-bold text-gray-900 border-b pb-2">{{ __('privasi.section_4') }}</h2>
                <p>Kami menerapkan langkah-langkah keamanan untuk melindungi data Anda:</p>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Enkripsi SSL/TLS untuk semua transmisi data</li>
                    <li>Server yang aman dan terenkripsi</li>
                    <li>Akses terbatas hanya untuk karyawan yang berwenang</li>
                    <li>Audit keamanan berkala</li>
                    <li>Backup data rutin</li>
                </ul>
            </section>
            
            <section>
                <h2 class="text-xl font-bold text-gray-900 border-b pb-2">{{ __('privasi.section_5') }}</h2>
                <p>Kami TIDAK akan menjual data pribadi Anda. Data hanya dibagikan kepada:</p>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Payment gateway (Midtrans) untuk proses pembayaran</li>
                    <li>Supir/partner untuk keperluan perjalanan</li>
                    <li>Otoritas hukum jika diwajibkan oleh undang-undang</li>
                </ul>
            </section>
            
            <section>
                <h2 class="text-xl font-bold text-gray-900 border-b pb-2">{{ __('privasi.section_6') }}</h2>
                <p>Anda berhak untuk:</p>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Mengakses data pribadi Anda</li>
                    <li>Memperbarui atau mengoreksi data yang tidak akurat</li>
                    <li>Menghapus data (dengan catatan kewajiban hukum)</li>
                    <li>Menolak pemasaran</li>
                    <li>Minta portabilitas data</li>
                </ul>
            </section>
            
            <section>
                <h2 class="text-xl font-bold text-gray-900 border-b pb-2">{{ __('privasi.section_7') }}</h2>
                <p>Kami menggunakan cookies untuk meningkatkan pengalaman Anda. Anda bisa mengatur preferensi cookies melalui browser Anda.</p>
            </section>
            
            <section>
                <h2 class="text-xl font-bold text-gray-900 border-b pb-2">{{ __('privasi.section_8') }}</h2>
                <p>Untuk pertanyaan tentang privasi data, hubungi Data Protection Officer kami:</p>
                <ul class="list-none space-y-1 mt-2">
                    <li>
                        <svg class="w-4 h-4 inline text-blue-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Email: privacy@asr-go.com
                    </li>
                    <li>
                        <svg class="w-4 h-4 inline text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        WhatsApp: 0812-3456-7890
                    </li>
                </ul>
            </section>
        </div>
    </div>
</div>
@endsection
