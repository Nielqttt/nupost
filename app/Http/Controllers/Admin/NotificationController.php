<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostRequest;
use App\Models\RequestComment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class NotificationController extends Controller
{
    // ── Full notifications page ──────────────────────────────────
    public function index()
    {
        $new_requests = PostRequest::orderBy('created_at', 'desc')
            ->limit(50)
            ->get()
            ->map(fn($r) => [
                'id'         => 'req_' . $r->id,
                'title'      => 'New Request: ' . $r->title,
                'message'    => $r->requester . ' submitted a new post request.',
                'type'       => 'new_request',
                'is_read'    => (bool) ($r->admin_seen ?? false),
                'request_id' => $r->id,
                'created_at' => $r->created_at,
            ]);

        $new_comments = RequestComment::where('sender_role', 'requestor')
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get()
            ->map(fn($c) => [
                'id'         => 'cmt_' . $c->id,
                'title'      => 'Reply from ' . $c->sender_name,
                'message'    => Str::limit($c->message, 80),
                'type'       => 'comment',
                'is_read'    => (bool) ($c->admin_seen ?? false),
                'request_id' => $c->request_id,
                'created_at' => $c->created_at,
            ]);

        $notifications = $new_requests->concat($new_comments)
            ->sortByDesc('created_at')
            ->values();

        return view('admin.notifications', compact('notifications'));
    }

    // ── AJAX: fetch admin notifications for bell dropdown ─────────
    public function fetch()
    {
        $new_requests = PostRequest::orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(fn($r) => [
                'id'         => 'req_' . $r->id,
                'title'      => 'New Request: ' . $r->title,
                'message'    => $r->requester . ' submitted a new post request.',
                'type'       => 'new_request',
                'is_read'    => (bool) ($r->admin_seen ?? false),
                'request_id' => $r->id,
                'created_at' => $r->created_at,
            ]);

        $new_comments = RequestComment::where('sender_role', 'requestor')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(fn($c) => [
                'id'         => 'cmt_' . $c->id,
                'title'      => 'Reply from ' . $c->sender_name,
                'message'    => Str::limit($c->message, 80),
                'type'       => 'comment',
                'is_read'    => (bool) ($c->admin_seen ?? false),
                'request_id' => $c->request_id,
                'created_at' => $c->created_at,
            ]);

        $all = $new_requests->concat($new_comments)
            ->sortByDesc('created_at')
            ->values()
            ->take(15);

        $unread_requests = PostRequest::where('admin_seen', false)->count();
        $unread_comments = RequestComment::where('sender_role', 'requestor')
            ->where('admin_seen', false)
            ->count();

        return response()->json([
            'notifications' => $all,
            'unread_count'  => $unread_requests + $unread_comments,
        ]);
    }

    // ── AJAX: mark as read ────────────────────────────────────────
    public function markRead(Request $request)
    {
        if ($request->input('all')) {
            PostRequest::where('admin_seen', false)->update(['admin_seen' => true]);
            RequestComment::where('sender_role', 'requestor')
                ->where('admin_seen', false)
                ->update(['admin_seen' => true]);
        } elseif ($id = $request->input('id')) {
            if (str_starts_with($id, 'req_')) {
                PostRequest::where('id', str_replace('req_', '', $id))
                    ->update(['admin_seen' => true]);
            } elseif (str_starts_with($id, 'cmt_')) {
                RequestComment::where('id', str_replace('cmt_', '', $id))
                    ->update(['admin_seen' => true]);
            }
        }

        return response()->json(['success' => true]);
    }
}