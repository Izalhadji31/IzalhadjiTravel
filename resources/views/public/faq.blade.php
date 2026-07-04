@extends('layouts.public')

@section('title', 'FAQ - Pertanyaan Umum - ASR GO')

@section('meta')
<meta name="description" content="Pertanyaan yang sering diajukan tentang layanan ASR GO Travel di Flores">
@endsection

@section('content')
<!-- HERO -->
<div style="background: linear-gradient(135deg, #0d2147 0%, #1e3a8a 100%); padding: 4rem 0;">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h1 class="text-4xl font-extrabold text-white mb-4">Pertanyaan Umum (FAQ)</h1>
        <p class="text-blue-200 text-lg">Temukan jawaban untuk pertanyaan yang sering diajukan</p>
        
        <!-- Search -->
        <div class="mt-8 max-w-md mx-auto">
            <input type="text" id="faqSearch" oninput="searchFAQ()" placeholder="Cari pertanyaan..." 
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

        @php $categories = ['booking' => 'Pemesanan', 'pembayaran' => 'Pembayaran', 'pembatalan' => 'Pembatalan & Refund', 'perjalanan' => 'Perjalanan', 'rental' => 'Rental Mobil', 'tracking' => 'Tracking', 'kontak' => 'Kontak & Bantuan']; @endphp

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
            <h3 class="text-xl font-bold text-gray-900 mb-2">Masih punya pertanyaan?</h3>
            <p class="text-gray-600 mb-4">Tim kami siap membantu Anda</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="https://wa.me/6281234567890?text=Halo ASR GO, saya ada pertanyaan" class="px-6 py-3 bg-green-500 text-white rounded-xl font-medium hover:bg-green-600 transition flex items-center gap-2">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                    Chat WhatsApp
                </a>
                <a href="/public/contact" class="px-6 py-3 bg-white text-blue-600 border border-blue-200 rounded-xl font-medium hover:bg-blue-50 transition">
                    Kirim Pesan
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
