<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\TravelBooking;
use App\Models\User;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
        $this->middleware('auth');
    }

    /**
     * List all conversations for the authenticated user.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Get all unique conversations - the latest message from each conversation
        $conversations = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver', 'booking'])
            ->latest()
            ->get()
            ->unique(function ($message) use ($userId) {
                // Group by the other user in the conversation
                return $message->sender_id == $userId
                    ? $message->receiver_id
                    : $message->sender_id;
            })
            ->map(function ($message) use ($userId) {
                $otherUser = $message->sender_id == $userId
                    ? $message->receiver
                    : $message->sender;

                return [
                    'other_user' => $otherUser,
                    'last_message' => $message,
                    'unread_count' => Message::unread()
                        ->where('receiver_id', $userId)
                        ->where('sender_id', $otherUser->id)
                        ->when($message->booking_id, function ($q) use ($message) {
                            $q->where('booking_id', $message->booking_id);
                        }, function ($q) use ($message) {
                            $q->whereNull('booking_id');
                        })
                        ->count(),
                    'booking_id' => $message->booking_id,
                ];
            });

        return view('chat.index', compact('conversations'));
    }

    /**
     * Show chat with a specific user (and optionally a booking).
     */
    public function show(Request $request, User $user, TravelBooking $booking = null)
    {
        $userId = Auth::id();

        $messages = Message::betweenUsers($userId, $user->id)
            ->when($booking, function ($q) use ($booking) {
                $q->where('booking_id', $booking->id);
            }, function ($q) {
                $q->whereNull('booking_id');
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark unread messages as read
        Message::unread()
            ->where('receiver_id', $userId)
            ->where('sender_id', $user->id)
            ->when($booking, function ($q) use ($booking) {
                $q->where('booking_id', $booking->id);
            }, function ($q) {
                $q->whereNull('booking_id');
            })
            ->update(['is_read' => true]);

        return view('chat.show', compact('messages', 'user', 'booking'));
    }

    /**
     * Store a new message.
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
            'type' => 'in:text,image|nullable',
            'booking_id' => 'nullable|exists:travel_bookings,id',
            'send_via' => 'in:in_app,whatsapp|nullable',
        ]);

        $senderId = Auth::id();
        $sendVia = $request->input('send_via', 'in_app');
        $type = $request->input('type', 'text');

        // Create message in database
        $message = Message::create([
            'sender_id' => $senderId,
            'receiver_id' => $request->input('receiver_id'),
            'booking_id' => $request->input('booking_id'),
            'message' => $request->input('message'),
            'type' => $type,
            'is_read' => false,
            'sent_via' => $sendVia === 'whatsapp' ? 'in_app' : $sendVia,
        ]);

        $message->load('sender', 'receiver');

        // Optionally send via WhatsApp
        if ($sendVia === 'whatsapp') {
            $receiver = User::find($request->input('receiver_id'));

            if ($receiver && $receiver->phone) {
                $this->whatsappService->send($receiver->phone, $request->input('message'));

                // If sent via WhatsApp, update the sent_via field
                $message->update(['sent_via' => 'whatsapp']);
            }
        }

        // If AJAX request, return JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        }

        return redirect()->back()->with('success', 'Message sent successfully!');
    }
}
