<?php

namespace App\Services;

use App\Models\TravelBooking;
use App\Models\RentalBooking;
use App\Models\Payment;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class BookingNotificationService
{
    protected WhatsAppService $whatsApp;

    public function __construct(WhatsAppService $whatsApp)
    {
        $this->whatsApp = $whatsApp;
    }

    /**
     * Notify customer when booking is created
     */
    public function notifyBookingCreated(TravelBooking|RentalBooking $booking): void
    {
        $user = $booking->user;
        $bookingType = $booking instanceof TravelBooking ? 'Travel' : 'Rental';
        $bookingCode = $booking->booking_code ?? ('#' . $booking->id);

        $message = "✅ *BOOKING {$bookingType} BERHASIL*\n\n";
        $message .= "Kode Booking: {$bookingCode}\n";
        
        if ($booking instanceof TravelBooking && $booking->route) {
            $message .= "Rute: {$booking->route->origin_city} → {$booking->route->destination_city}\n";
        } elseif ($booking instanceof RentalBooking && $booking->route) {
            $message .= "Destinasi: {$booking->route->destination_city}\n";
        }
        
        if ($booking->scheduled_date) {
            $message .= "Tanggal: " . $booking->scheduled_date->format('d-m-Y') . "\n";
        } elseif ($booking instanceof RentalBooking && $booking->start_date) {
            $message .= "Tanggal: " . $booking->start_date->format('d-m-Y') . " s/d " . $booking->end_date->format('d-m-Y') . "\n";
        }
        
        $message .= "Total: Rp " . number_format($booking->total_price, 0, ',', '.') . "\n\n";
        $message .= "Silakan lakukan pembayaran untuk mengkonfirmasi booking Anda.\n";
        $message .= "Batas pembayaran: 24 jam\n\n";
        $message .= "Terima kasih telah menggunakan ASR GO! 🚗";

        $this->sendAndLog($user, 'booking_created', $message, $user->phone);
    }

    /**
     * Notify customer when booking is confirmed
     */
    public function notifyBookingConfirmed(TravelBooking|RentalBooking $booking): void
    {
        $user = $booking->user;
        $bookingType = $booking instanceof TravelBooking ? 'Travel' : 'Rental';
        $bookingCode = $booking->booking_code ?? ('#' . $booking->id);

        $message = "🎉 *BOOKING DIKONFIRMASI*\n\n";
        $message .= "Kode Booking: {$bookingCode}\n";
        $message .= "Jenis: {$bookingType}\n";
        
        if ($booking->armada) {
            $message .= "Kendaraan: {$booking->armada->vehicle_type} ({$booking->armada->plate_number})\n";
        }
        
        if ($booking->driver) {
            $message .= "Driver: {$booking->driver->user->name}\n";
        }
        
        $message .= "\nBooking Anda telah dikonfirmasi. Selamat menikmati perjalanan dengan ASR GO! 🛡️";

        $this->sendAndLog($user, 'booking_confirmed', $message, $user->phone);
    }

    /**
     * Notify customer when booking is completed
     */
    public function notifyBookingCompleted(TravelBooking|RentalBooking $booking): void
    {
        $user = $booking->user;
        $bookingCode = $booking->booking_code ?? ('#' . $booking->id);

        $message = "✓ *PERJALANAN SELESAI*\n\n";
        $message .= "Kode Booking: {$bookingCode}\n";
        $message .= "Status: Selesai\n\n";
        $message .= "Terima kasih telah menggunakan ASR GO!\n";
        $message .= "Berikan rating dan review untuk driver Anda di aplikasi. ⭐";

        $this->sendAndLog($user, 'booking_completed', $message, $user->phone);
    }

    /**
     * Notify customer when booking is cancelled
     */
    public function notifyBookingCancelled(TravelBooking|RentalBooking $booking): void
    {
        $user = $booking->user;
        $bookingType = $booking instanceof TravelBooking ? 'Travel' : 'Rental';
        $bookingCode = $booking->booking_code ?? ('#' . $booking->id);

        $message = "❌ *BOOKING DIBATALKAN*\n\n";
        $message .= "Kode Booking: {$bookingCode}\n";
        $message .= "Jenis: {$bookingType}\n";
        $message .= "Status: Dibatalkan\n\n";
        $message .= "Booking Anda telah dibatalkan. Jika ada pertanyaan, silakan hubungi customer service kami.\n\n";
        $message .= "Mohon maaf atas ketidaknyamanannya. 🙏";

        $this->sendAndLog($user, 'booking_cancelled', $message, $user->phone);
    }

    /**
     * Notify customer on payment success
     */
    public function notifyPaymentSuccess(Payment $payment): void
    {
        $booking = $payment->booking;
        
        if (!$booking) {
            Log::warning('Payment notification: booking not found for payment ' . $payment->id);
            return;
        }

        $user = $booking->user;
        $bookingCode = $booking->booking_code ?? ('#' . $booking->id);

        $message = "✅ *PEMBAYARAN BERHASIL*\n\n";
        $message .= "Kode Booking: {$bookingCode}\n";
        $message .= "Jumlah: Rp " . number_format($payment->amount, 0, ',', '.') . "\n";
        $message .= "Status: Berhasil\n";
        $message .= "Waktu: " . $payment->created_at->format('d-m-Y H:i') . "\n\n";
        $message .= "Terima kasih telah menggunakan ASR GO! 🎉";

        $this->sendAndLog($user, 'payment_success', $message, $user->phone);
    }

    /**
     * Notify driver when assigned to a booking
     */
    public function notifyDriverAssigned(TravelBooking|RentalBooking $booking): void
    {
        $driver = $booking->driver;
        
        if (!$driver || !$driver->user) {
            Log::warning('Driver notification: no driver assigned to booking ' . $booking->id);
            return;
        }

        $user = $driver->user;
        $bookingCode = $booking->booking_code ?? ('#' . $booking->id);

        $message = "🚗 *PENUGASAN BARU*\n\n";
        $message .= "Kode Booking: {$bookingCode}\n";
        
        if ($booking instanceof TravelBooking && $booking->route) {
            $message .= "Rute: {$booking->route->origin_city} → {$booking->route->destination_city}\n";
        }
        
        if ($booking->scheduled_date) {
            $message .= "Tanggal: " . $booking->scheduled_date->format('d-m-Y') . "\n";
        }
        
        $message .= "Penumpang: {$booking->passenger_count}\n\n";
        $message .= "Segera lakukan penjemputan sesuai jadwal. Terima kasih! 💪";

        $this->sendAndLog($user, 'driver_assigned', $message, $user->phone);
    }

    /**
     * Send WhatsApp and log notification
     */
    protected function sendAndLog($user, string $type, string $message, ?string $phone): void
    {
        $status = 'pending';

        if ($phone) {
            $sent = $this->whatsApp->send($phone, $message);
            $status = $sent ? 'sent' : 'failed';
        } else {
            $status = 'failed';
            Log::warning("WhatsApp notification: no phone number for user {$user->id}, type: {$type}");
        }

        // Log to notifications table
        Notification::create([
            'user_id' => $user->id,
            'type' => 'whatsapp',
            'trigger' => $type,
            'notifiable_type' => get_class($user),
            'notifiable_id' => $user->id,
            'title' => ucfirst(str_replace('_', ' ', $type)),
            'message' => $message,
            'send_to' => $phone,
            'status' => $status,
            'sent_at' => $status === 'sent' ? now() : null,
        ]);
    }
}
