<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostRequest;
use App\Models\RequestComment;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class NotificationController extends Controller
{
    private function getAdminId(): ?int
    {
        $adminId = session('admin_id');
        if (!$adminId && session('admin_email')) {
            $adminId = User::where('email', session('admin_email'))->value('id');
        }
        return $adminId ? (int) $adminId : null;
    }

    // ── Full notifications page ──────────────────────────────────
    public function index()
    {
        $adminId = $this->getAdminId();

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

        $system_notifs = Notification::where(function ($q) use ($adminId) {
                $q->whereNull('user_id')
                  ->orWhere('user_id', 0)
                  ->orWhereIn('type', ['system', 'api_key', 'admin']);
                if ($adminId) {
                    $q->orWhere('user_id', $adminId);
                }
            })
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get()
            ->map(fn($n) => [
                'id'         => 'notif_' . $n->id,
                'title'      => $n->title,
                'message'    => $n->message,
                'type'       => $n->type ?: 'system',
                'is_read'    => (bool) $n->is_read,
                'request_id' => null,
                'created_at' => $n->created_at,
            ]);

        $notifications = $new_requests->concat($new_comments)->concat($system_notifs)
            ->sortByDesc('created_at')
            ->values();

        return view('admin.notifications', compact('notifications'));
    }

    // ── AJAX: fetch admin notifications for bell dropdown ─────────
    public function fetch()
    {
        $adminId = $this->getAdminId();

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

        $system_notifs = Notification::where(function ($q) use ($adminId) {
                $q->whereNull('user_id')
                  ->orWhere('user_id', 0)
                  ->orWhereIn('type', ['system', 'api_key', 'admin']);
                if ($adminId) {
                    $q->orWhere('user_id', $adminId);
                }
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(fn($n) => [
                'id'         => 'notif_' . $n->id,
                'title'      => $n->title,
                'message'    => $n->message,
                'type'       => $n->type ?: 'system',
                'is_read'    => (bool) $n->is_read,
                'request_id' => null,
                'created_at' => $n->created_at,
            ]);

        $all = $new_requests->concat($new_comments)->concat($system_notifs)
            ->sortByDesc('created_at')
            ->values()
            ->take(15);

        $unread_requests = PostRequest::where('admin_seen', false)->count();
        $unread_comments = RequestComment::where('sender_role', 'requestor')
            ->where('admin_seen', false)
            ->count();
        $unread_system   = Notification::where(function ($q) use ($adminId) {
                $q->whereNull('user_id')
                  ->orWhere('user_id', 0)
                  ->orWhereIn('type', ['system', 'api_key', 'admin']);
                if ($adminId) {
                    $q->orWhere('user_id', $adminId);
                }
            })
            ->where('is_read', false)
            ->count();

        return response()->json([
            'notifications' => $all,
            'unread_count'  => $unread_requests + $unread_comments + $unread_system,
        ]);
    }

    // ── AJAX: mark as read ────────────────────────────────────────
    public function markRead(Request $request)
    {
        $adminId = $this->getAdminId();

        if ($request->input('all')) {
            PostRequest::where('admin_seen', false)->update(['admin_seen' => true]);
            RequestComment::where('sender_role', 'requestor')
                ->where('admin_seen', false)
                ->update(['admin_seen' => true]);
            Notification::where(function ($q) use ($adminId) {
                $q->whereNull('user_id')
                  ->orWhere('user_id', 0)
                  ->orWhereIn('type', ['system', 'api_key', 'admin']);
                if ($adminId) {
                    $q->orWhere('user_id', $adminId);
                }
            })->where('is_read', false)->update(['is_read' => true]);
        } elseif ($id = $request->input('id')) {
            if (str_starts_with($id, 'req_')) {
                PostRequest::where('id', str_replace('req_', '', $id))
                    ->update(['admin_seen' => true]);
            } elseif (str_starts_with($id, 'cmt_')) {
                RequestComment::where('id', str_replace('cmt_', '', $id))
                    ->update(['admin_seen' => true]);
            } elseif (str_starts_with($id, 'notif_')) {
                Notification::where('id', str_replace('notif_', '', $id))
                    ->update(['is_read' => true]);
            } else {
                Notification::where('id', $id)
                    ->update(['is_read' => true]);
            }
        }

        return response()->json(['success' => true]);
    }
}