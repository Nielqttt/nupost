<?php

namespace App\Http\Controllers\Requestor;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display the notifications page with pagination
     */
    public function index()
    {
        $user_id = session('user_id');

        // Paginate 5 items per page gaya ng request mo
        $notifications = Notification::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        // Para sa badge count sa sidebar/header
        $unread_count = Notification::where('user_id', $user_id)
            ->where('is_read', false)
            ->count();

        return view('requestor.notifications', compact('notifications', 'unread_count'));
    }

    /**
     * AJAX: Fetch notifications for the bell icon dropdown
     */
    public function fetch()
    {
        $user_id = session('user_id');

        $notifications = Notification::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $unread_count = Notification::where('user_id', $user_id)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count'  => $unread_count,
        ]);
    }

    /**
     * AJAX: Mark notification as read
     */
    public function markRead(Request $request)
    {
        $user_id = session('user_id');
        $id = $request->input('id');

        if ($request->input('all')) {
            Notification::where('user_id', $user_id)->update(['is_read' => true]);
        } else {
            Notification::where('id', $id)
                ->where('user_id', $user_id)
                ->update(['is_read' => true]);
        }

        return response()->json(['success' => true]);
    }
}