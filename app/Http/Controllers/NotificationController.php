<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the user's notifications.
     */
    public function index()
    {
        $notifications = Auth::user()
            ->notifications()
            ->latest()
            ->paginate(20);

        $unreadCount = Auth::user()
            ->notifications()
            ->unread()
            ->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Mark a single notification as read and redirect.
     */
    public function markRead(Notification $notification)
    {
        if (Auth::id() !== $notification->user_id) {
            abort(403);
        }

        $notification->markAsRead();

        // Determine redirect URL based on notifiable type
        $url = $this->getNotifiableUrl($notification);

        return redirect($url);
    }

    /**
     * Mark all unread notifications as read for the authenticated user.
     */
    public function markAllRead()
    {
        Auth::user()
            ->notifications()
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return redirect()->route('notifications.index');
    }

    /**
     * Remove the specified notification from storage.
     */
    public function destroy(Notification $notification)
    {
        if (Auth::id() !== $notification->user_id) {
            abort(403);
        }

        $notification->delete();

        return redirect()->route('notifications.index')
            ->with('success', 'Notifikasi berhasil dihapus.');
    }

    /**
     * Get the URL for the notifiable entity.
     */
    private function getNotifiableUrl(Notification $notification): string
    {
        if (!$notification->notifiable_type || !$notification->notifiable_id) {
            return route('notifications.index');
        }

        $notifiable = $notification->notifiable;

        if (!$notifiable) {
            return route('notifications.index');
        }

        // Map notifiable types to their URL patterns
        $type = strtolower(class_basename($notification->notifiable_type));

        switch ($type) {
            case 'travelbooking':
                return route('bookings.travel.show', $notifiable);
            case 'rentalbooking':
                return route('bookings.rental.show', $notifiable);
            case 'airporttransferbooking':
                return route('bookings.airport-transfer.show', $notifiable);
            case 'payment':
                return route('payments.travel', $notifiable);
            default:
                return route('notifications.index');
        }
    }
}
