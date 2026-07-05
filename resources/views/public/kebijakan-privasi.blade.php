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
                    <li>📧 Email: privacy@asr-go.com</li>
                    <li>📱 WhatsApp: 0812-3456-7890</li>
                </ul>
            </section>
        </div>
    </div>
</div>
@endsection
