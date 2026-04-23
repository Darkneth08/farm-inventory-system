<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserNotification;
use Illuminate\Http\Request;

class UserNotificationController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'is_read' => 'nullable|boolean',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $query = UserNotification::query()
            ->where('user_id', $request->user()->id)
            ->latest();

        if (array_key_exists('is_read', $data)) {
            $query->where('is_read', (bool) $data['is_read']);
        }

        $perPage = $data['per_page'] ?? 20;

        return response()->json(
            $query->paginate($perPage)->appends($request->query())
        );
    }

    public function markAsRead(Request $request, UserNotification $notification)
    {
        if ((int) $notification->user_id !== (int) $request->user()->id) {
            return response()->json(['message' => 'You can only update your own notifications'], 403);
        }

        if (!$notification->is_read) {
            $notification->is_read = true;
            $notification->read_at = now();
            $notification->save();
        }

        return response()->json([
            'message' => 'Notification marked as read.',
            'notification' => $notification,
        ]);
    }

    public function markAllAsRead(Request $request)
    {
        $updated = UserNotification::query()
            ->where('user_id', $request->user()->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
                'updated_at' => now(),
            ]);

        return response()->json([
            'message' => 'All notifications marked as read.',
            'updated' => $updated,
        ]);
    }
}

