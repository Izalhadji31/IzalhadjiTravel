@extends('layouts.public')

@section('title', __('faq.title') . ' - ASR GO')

@section('meta')
<meta name="description" content="Pertanyaan yang sering diajukan tentang layanan ASR GO Travel di Flores">
@endsection

@section('content')
<!-- HERO -->
<div style="background: linear-gradient(135deg, #0d2147 0%, #1e3a8a 100%); padding: 4rem 0;">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h1 class="text-4xl font-extrabold text-white mb-4">{{ __('faq.title') }}</h1>
        <p class="text-blue-200 text-lg">{{ __('faq.subtitle') }}</p>
        
        <!-- Search -->
        <div class="mt-8 max-w-md mx-auto">
            <input type="text" id="faqSearch" oninput="searchFAQ()" placeholder="{{ __('faq.search_placeholder') }}" 
                   class="w-full px-5 py-3.5 rounded-xl bg-white/95 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-300">
        </div>
    </div>
</div>

<!-- FAQ CONTENT -->
<div class="bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @php
        $faqs = [
            ['cat' => 'booking', 'q' => 'Bagaimana cara memesan travel/rental di ASR GO?', 'a' => 'Anda bisa memesan langsung melalui website kami di halaman Travel atau Rental. Pilih rute, tanggal, dan jumlah penumpang, lalu lakukan pembayaran via transfer, e-wallet, atau kartu kredit melalui Midtrans.'],
            ['cat' => 'booking', 'q' => 'Apakah perlu membuat akun untuk pesan?', 'a' => 'Ya, Anda perlu membuat akun untuk melakukan pemesanan. Proses registrasi hanya butuh 1 menit dan Anda bisa login dengan email/password atau Google.'],
            ['cat' => 'booking', 'q' => 'Berapa hari sebelumnya saya harus booking?', 'a' => 'Kami merekomendasikan booking minimal 1 hari sebelum keberangkatan. Namun untuk peak season (Desember-Juni), disanakan 3-7 hari sebelumnya.'],
            ['cat' => 'pembayaran', 'q' => 'Metode pembayaran apa saja yang diterima?', 'a' => 'Kami menerima: Transfer Bank (BCA, BRI, BNI, Mandiri), GoPay, OVO, Dana, ShopeePay, LinkAja, dan Kartu Kredit/Debit (Visa, Mastercard).'],
            ['cat' => 'pembayaran', 'q' => 'Apakah DP bisa?', 'a' => 'Ya, Anda bisa membayar DP minimal 50% dari total harga. Sisa pembayaran bisa dibayar di tempat (cash) sebelum keberangkatan.'],
            ['cat' => 'pembayaran', 'q' => 'Apakah uang saya aman?', 'a' => 'Tentu! Kami menggunakan payment gateway Midtrans yang sudah tersertifikasi PCI DSS. Data pembayaran Anda 100% aman.'],
            ['cat' => 'pembatalan', 'q' => 'Bagaimana jika saya perlu membatalkan pesanan?', 'a' => 'Pembatalan bisa dilakukan melalui dashboard akun Anda. Mohon diperhatikan kebijakan refund kami di bawah.'],
            ['cat' => 'pembatalan', 'q' => 'Berapa refund yang saya dapat?', 'a' => 'Pembatalan 7+ hari sebelum: refund 90%. 3-6 hari: refund 50%. 1-2 hari: refund 25%. H-1 atau no-show: tidak ada refund. Biaya admin dan payment gateway tidak termasuk.'],
            ['cat' => 'perjalanan', 'q' => 'Apakah titik jemput bisa di hotel/alamat?', 'a' => 'Ya! Kami menyediakan layanan door-to-door. Anda bisa mengisi alamat jemput saat booking. Untuk area pusat kota Ende, Maumere, Bajawa: gratis. Untuk area luar kota: ada biaya tambahan.'],
            ['cat' => 'perjalanan', 'q' => 'Berapa lama perjalanan dari Ende ke Labuan Bajo?', 'a' => 'Estimasi perjalanan Ende ke Labuan Bajo adalah 8-10 jam (sekitar 280 km). Dengan rental mobil, waktu lebih fleksibel tergantung istirahat dan singgah.'],
            ['cat' => 'perjalanan', 'q' => 'Apakah ada AC dan charger di mobil?', 'a' => 'Semua armada kami dilengkapi AC dan USB charger. Untuk travel, setiap kursi memiliki charger port masing-masing.'],
            ['cat' => 'perjalanan', 'q' => 'Boleh bawa bagasi berapa?', 'a' => 'Setiap penumpang boleh membawa 1 bagasi besar (max 20kg) dan 1 bagasi kecil. Untuk kelebihan bagasi, ada biaya tambahan Rp 25.000/item.'],
            ['cat' => 'rental', 'q' => 'Apa saja persyaratan sewa mobil?', 'a' => 'KTP/SIM yang masih berlaku, SIM A (untuk rental lepas kartu), dan deposit Rp 500.000 (dikembalikan saat serah terima mobil).'],
            ['cat' => 'rental', 'q' => 'Apakah ada supir atau lepas kunci?', 'a' => 'Keduanya tersedia. Harga rental sudah termasuk bahan bakar. Jika lepas kunci, wajib menyerahkan SIM A asli sebagai jaminan.'],
            ['cat' => 'rental', 'q' => 'Apakah boleh keluar kota dari Ende?', 'a' => 'Ya, mobil rental boleh digunakan di seluruh wilayah Flores. Tidak diperbolehkan menyeberang ke luar pulau (misalnya ke Sumba atau Timor).'],
            ['cat' => 'tracking', 'q' => 'Bagaimana cara tracking perjalanan saya?', 'a' => 'Setelah booking, Anda akan mendapat kode booking. Tracking bisa dilakukan di halaman "Cek Booking" tanpa perlu login, cukup masukkan kode dan email.'],
            ['cat' => 'kontak', 'q' => 'Bagaimani jika saya butuh bantuan saat perjalanan?', 'a' => 'Supir kami bisa dihubungi via WhatsApp yang dikirimkan sebelum keberangkatan. Untuk darurat, hubungi hotline kami 24 jam di 0812-3456-7890.'],
            ['cat' => 'kontak', 'q' => 'Apakah ada layanan WhatsApp untuk konsultasi?', 'a' => 'Ya! Anda bisa chat kami di 0812-3456-7890 via WhatsApp untuk tanya-tanya rute, harga, atau booking. Response time rata-rata 5 menit.'],
        ];
        @endphp

        @php $categories = ['booking' => __('faq.category_booking'), 'pembayaran' => __('faq.category_payment'), 'pembatalan' => __('faq.category_cancellation'), 'perjalanan' => __('faq.category_travel'), 'rental' => __('faq.category_rental'), 'tracking' => __('faq.category_tracking'), 'kontak' => __('faq.category_contact')]; @endphp

        @foreach($categories as $cat_key => $cat_name)
        @php $cat_faqs = array_filter($faqs, fn($f) => $f['cat'] === $cat_key); @endphp
        @if(count($cat_faqs) > 0)
        <div class="mb-8" data-cat="{{ $cat_key }}">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-sm font-bold">{{ $loop->iteration }}</span>
                {{ $cat_name }}
            </h2>
            <div class="space-y-3">
                @foreach($cat_faqs as $faq)
                <div class="faq-item bg-white rounded-xl shadow-sm overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex items-center justify-between gap-4 hover:bg-gray-50 transition">
                        <span class="font-medium text-gray-900">{{ $faq['q'] }}</span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform faq-icon flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="faq-answer hidden px-6 pb-4">
                        <p class="text-gray-600 leading-relaxed">{{ $faq['a'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        @endforeach

        <!-- Still have questions? -->
        <div class="bg-blue-50 rounded-2xl p-8 text-center mt-10">
            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('faq.still_question') }}</h3>
            <p class="text-gray-600 mb-4">{{ __('faq.still_question_desc') }}</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="tel:+6283156408078" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    {{ __('faq.call_center') }}
                </a>
                <a href="/public/contact" class="px-6 py-3 bg-white text-blue-600 border border-blue-200 rounded-xl font-medium hover:bg-blue-50 transition">
                    {{ __('faq.send_message') }}
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function toggleFaq(btn) {
    const answer = btn.nextElementSibling;
    const icon = btn.querySelector('.faq-icon');
    answer.classList.toggle('hidden');
    icon.style.transform = answer.classList.contains('hidden') ? '' : 'rotate(180deg)';
}
function searchFAQ() {
    const q = document.getElementById('faqSearch').value.toLowerCase();
    document.querySelectorAll('.faq-item').forEach(item => {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(q) ? 'block' : 'none';
    });
}
</script>
@endsection
