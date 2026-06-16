<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $apiKey;
    protected $apiUrl;
    protected $gateway; // 'fonnte' or 'wablas'

    public function __construct()
    {
        $this->gateway = config('services.whatsapp.gateway', 'fonnte');
        $this->apiKey = config('services.whatsapp.api_key');
        $this->apiUrl = config('services.whatsapp.api_url');
    }

    /**
     * Send WhatsApp message
     */
    public function send($phoneNumber, $message, $mediaUrl = null)
    {
        if (!$this->apiKey || !$this->apiUrl) {
            Log::warning('WhatsApp service not configured');
            return false;
        }

        try {
            $response = $this->gateway === 'fonnte'
                ? $this->sendViaFonnte($phoneNumber, $message, $mediaUrl)
                : $this->sendViaWablas($phoneNumber, $message, $mediaUrl);

            return $response;
        } catch (\Exception $e) {
            Log::error('WhatsApp send failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send via Fonnte
     */
    protected function sendViaFonnte($phoneNumber, $message, $mediaUrl = null)
    {
        $payload = [
            'target' => $this->formatPhoneNumber($phoneNumber),
            'message' => $message,
        ];

        if ($mediaUrl) {
            $payload['url'] = $mediaUrl;
        }

        $response = Http::withHeaders([
            'Authorization' => $this->apiKey,
        ])->post($this->apiUrl . '/send', $payload);

        return $response->successful();
    }

    /**
     * Send via Wablas
     */
    protected function sendViaWablas($phoneNumber, $message, $mediaUrl = null)
    {
        $payload = [
            'phone' => $this->formatPhoneNumber($phoneNumber),
            'message' => $message,
        ];

        if ($mediaUrl) {
            $payload['media_url'] = $mediaUrl;
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->apiUrl . '/api/send-message', $payload);

        return $response->successful();
    }

    /**
     * Format phone number to 62xxxxxxxxxx
     */
    protected function formatPhoneNumber($phoneNumber)
    {
        $phoneNumber = str_replace(['+', '-', ' '], '', $phoneNumber);

        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        }

        if (substr($phoneNumber, 0, 2) !== '62') {
            $phoneNumber = '62' . $phoneNumber;
        }

        return $phoneNumber;
    }

    /**
     * Send booking confirmation
     */
    public function sendBookingConfirmation($booking)
    {
        $message = $this->buildBookingMessage($booking);
        return $this->send($booking->user->phone, $message);
    }

    /**
     * Send payment confirmation
     */
    public function sendPaymentConfirmation($payment, $booking)
    {
        $message = "✅ *PEMBAYARAN BERHASIL*\n\n";
        $message .= "Kode Booking: {$booking->booking_code}\n";
        $message .= "Jumlah: Rp " . number_format($payment->amount, 0, ',', '.') . "\n";
        $message .= "Status: Berhasil\n";
        $message .= "Waktu: " . $payment->created_at->format('d-m-Y H:i') . "\n\n";
        $message .= "Terima kasih telah menggunakan ASR GO!";

        return $this->send($booking->user->phone, $message);
    }

    /**
     * Send pickup reminder
     */
    public function sendPickupReminder($booking)
    {
        $message = "⏰ *PENGINGAT PENJEMPUTAN*\n\n";
        $message .= "Booking: {$booking->booking_code}\n";
        $message .= "Tanggal: " . $booking->scheduled_date->format('d-m-Y') . "\n";
        $message .= "Jam: " . ($booking->departure_time ? $booking->departure_time->format('H:i') : 'TBD') . "\n";
        $message .= "Rute: {$booking->route->from_location->city} → {$booking->route->to_location->city}\n\n";
        $message .= "Pastikan Anda siap 15 menit sebelum waktu keberangkatan.";

        return $this->send($booking->user->phone, $message);
    }

    /**
     * Send trip started notification
     */
    public function sendTripStarted($booking)
    {
        $message = "🚗 *PERJALANAN DIMULAI*\n\n";
        $message .= "Booking: {$booking->booking_code}\n";
        $message .= "Driver: {$booking->driver?->user->name}\n";
        $message .= "Nomor Kontak: {$booking->driver?->user->phone}\n\n";
        $message .= "Perjalanan Anda sudah dimulai. Terima kasih telah memilih ASR GO!";

        return $this->send($booking->user->phone, $message);
    }

    /**
     * Send trip completed notification
     */
    public function sendTripCompleted($booking)
    {
        $message = "✓ *PERJALANAN SELESAI*\n\n";
        $message .= "Booking: {$booking->booking_code}\n";
        $message .= "Terima kasih telah menggunakan ASR GO!\n\n";
        $message .= "Berikan rating dan review untuk driver Anda di aplikasi.";

        return $this->send($booking->user->phone, $message);
    }

    /**
     * Send identity verification reminder
     */
    public function sendVerificationReminder($user)
    {
        $message = "📝 *VERIFIKASI IDENTITAS DIPERLUKAN*\n\n";
        $message .= "Oleh peraturan platform, kami meminta Anda melakukan verifikasi identitas.\n\n";
        $message .= "Caranya:\n";
        $message .= "1. Buka aplikasi ASR GO\n";
        $message .= "2. Pilih menu 'Verifikasi Identitas'\n";
        $message .= "3. Unggah foto KTP atau SIM Anda\n\n";
        $message .= "Verifikasi identitas memungkinkan Anda menikmati semua fitur platform.";

        return $this->send($user->phone, $message);
    }

    /**
     * Build booking message
     */
    protected function buildBookingMessage($booking)
    {
        $message = "✅ *BOOKING BERHASIL*\n\n";
        $message .= "Kode Booking: {$booking->booking_code}\n";
        $message .= "Rute: {$booking->route->from_location->city} → {$booking->route->to_location->city}\n";
        $message .= "Tanggal: " . $booking->scheduled_date->format('d-m-Y') . "\n";
        $message .= "Jumlah Kursi: {$booking->number_of_seats}\n";
        $message .= "Harga: Rp " . number_format($booking->total_price, 0, ',', '.') . "\n\n";
        $message .= "Silakan lakukan pembayaran untuk mengkonfirmasi booking Anda.\n";
        $message .= "Batas pembayaran: 24 jam\n\n";
        $message .= "Perjalanan Anda dijamin aman dengan ASR GO 🛡️";

        return $message;
    }
}
