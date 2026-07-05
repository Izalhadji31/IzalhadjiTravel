@extends('layouts.public')

@section('title', __('syarat.title') . ' - ASR GO')

@section('content')
<div class="bg-white py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-2">{{ __('syarat.title') }}</h1>
        <p class="text-gray-500 mb-8">{{ __('syarat.last_updated') }}</p>
        
        <div class="prose prose-gray max-w-none space-y-6 text-gray-700">
            <section>
                <h2 class="text-xl font-bold text-gray-900 border-b pb-2">{{ __('syarat.section_1') }}</h2>
                <p>Dengan mengakses dan menggunakan layanan ASR GO ("Kami"), Anda menyetujui untuk terikat oleh Syarat & Ketentuan ini. Jika Anda tidak setuju dengan bagian apapun dari syarat ini, Anda tidak boleh menggunakan layanan kami.</p>
                <p>PT ASR Go Indonesia ("ASR GO") adalah perusahaan yang menyediakan layanan transportasi travel antar kota, rental mobil, dan airport transfer di wilayah Flores, Nusa Tenggara Timur.</p>
            </section>
            
            <section>
                <h2 class="text-xl font-bold text-gray-900 border-b pb-2">{{ __('syarat.section_2') }}</h2>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Pemesanan berlaku setelah pembayaran diterima dan konfirmasi dikirimkan via email/WhatsApp</li>
                    <li>Anda akan menerima kode booking yang digunakan untuk tracking perjalanan</li>
                    <li>Pemesanan bersifat binding setelah konfirmasi diterbitkan</li>
                    <li>Kami berhak menolak pemesanan yang melanggar kebijakan kami</li>
                </ul>
            </section>
            
            <section>
                <h2 class="text-xl font-bold text-gray-900 border-b pb-2">{{ __('syarat.section_3') }}</h2>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Pembayaran dapat dilakukan via transfer bank, e-wallet (GoPay, OVO, Dana, ShopeePay), atau kartu kredit/debit</li>
                    <li>Harga tertera sudah termasuk pajak (PPn 11%)</li>
                    <li>DP minimal 50% untuk reservasi, sisa dibayar sebelum keberangkatan</li>
                    <li>Pembayaran diterima dalam Rupiah Indonesia (IDR)</li>
                </ul>
            </section>
            
            <section>
                <h2 class="text-xl font-bold text-gray-900 border-b pb-2">{{ __('syarat.section_4') }}</h2>
                <table class="w-full border-collapse border border-gray-300 text-sm mt-3">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2 text-left">Waktu Pembatalan</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Refund</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td class="border border-gray-300 px-4 py-2">7+ hari sebelum</td><td class="border border-gray-300 px-4 py-2">90%</td></tr>
                        <tr><td class="border border-gray-300 px-4 py-2">3-6 hari sebelum</td><td class="border border-gray-300 px-4 py-2">50%</td></tr>
                        <tr><td class="border border-gray-300 px-4 py-2">1-2 hari sebelum</td><td class="border border-gray-300 px-4 py-2">25%</td></tr>
                        <tr><td class="border border-gray-300 px-4 py-2">H-1 / No-show</td><td class="border border-gray-300 px-4 py-2">0%</td></tr>
                    </tbody>
                </table>
                <p class="mt-2 text-sm text-gray-500">* Biaya payment gateway dan admin tidak termasuk refund</p>
            </section>
            
            <section>
                <h2 class="text-xl font-bold text-gray-900 border-b pb-2">{{ __('syarat.section_5') }}</h2>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Penumpang wajib hadir 30 menit sebelum waktu keberangkatan</li>
                    <li>Keterlambatan lebih dari 15 menit tanpa konfirmasi dianggap no-show</li>
                    <li>Dilarang membawa barang berbahaya, narkotika, atau minuman beralkohol</li>
                    <li>Maskapkan berhak menolak penumpang yang mengganggu kenyamanan perjalanan</li>
                    <li>Bagasi maksimal 20kg per penumpang (kelebihan dikenakan biaya)</li>
                    <li>ASR GO tidak bertanggung jawab atas barang berharga yang tertinggal</li>
                </ul>
            </section>
            
            <section>
                <h2 class="text-xl font-bold text-gray-900 border-b pb-2">{{ __('syarat.section_6') }}</h2>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Penyewa wajib berusia minimal 21 tahun dan memiliki SIM A yang masih berlaku</li>
                    <li>Deposit Rp500.000 diserahkan sebelum pengambilan mobil (dikembalikan setelah serah terima)</li>
                    <li>Kerusakan akibat kelalaian penyewa menjadi tanggung jawab penyewa</li>
                    <li>Mobil tidak diperbolehkan digunakan untuk kegiatan illegal atau balapan</li>
                    <li>Km unlimited untuk rental 24 jam</li>
                </ul>
            </section>
            
            <section>
                <h2 class="text-xl font-bold text-gray-900 border-b pb-2">{{ __('syarat.section_7') }}</h2>
                <p>ASR GO bertanggung jawab atas keselamatan penumpang selama perjalanan. Namun, ASR GO tidak bertanggung jawab atas:</p>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Kehilangan barang pribadi penumpang</li>
                    <li>Keterlambatan akibat Force Majeure (bencana alam, kerusakan jalan, dll)</li>
                    <li>Kerugian yang disebabkan oleh perilaku penumpang sendiri</li>
                </ul>
            </section>
            
            <section>
                <h2 class="text-xl font-bold text-gray-900 border-b pb-2">{{ __('syarat.section_8') }}</h2>
                <p>Syarat & Ketentuan ini diatur berdasarkan hukum Republik Indonesia. Setiap perselisihan akan diselesaikan secara musyawarah terlebih dahulu, dan jika tidak tercapai, akan diselesaikan di Pengadilan Negeri Ende.</p>
            </section>
            
            <section>
                <h2 class="text-xl font-bold text-gray-900 border-b pb-2">{{ __('syarat.section_9') }}</h2>
                <p>Jika ada pertanyaan tentang Syarat & Ketentuan ini, hubungi kami:</p>
                <ul class="list-none space-y-1 mt-2">
                    <li>📧 Email: info@asr-go.com</li>
                    <li>📱 WhatsApp: 0812-3456-7890</li>
                    <li>📍 Alamat: Jl. Moh. Hatta No. 15, Ende, NTT</li>
                </ul>
            </section>
        </div>
    </div>
</div>
@endsection
