<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = Notification::where('user_id', $user->id);

        $notifications = $notifications->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        return response()->json([
            'success' => true,
            'notifications' => $notifications
        ]);
    }

    public function markAsRead($id)
    {
        $notification = Notification::find($id);
        if ($notification) {
            $notification->read = true;
            $notification->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }

    public function markAllRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('read', false)
            ->update(['read' => true]);

        return response()->json(['success' => true]);
    }
}
