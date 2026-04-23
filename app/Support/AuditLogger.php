<?php

namespace App\Support;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AuditLogger
{
    public static function log(
        ?Request $request,
        string $action,
        ?string $entityType = null,
        $entityId = null,
        ?array $details = null
    ): void {
        if (!Schema::hasTable('audit_logs')) {
            return;
        }

        AuditLog::create([
            'user_id' => $request?->user()?->id,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId !== null ? (string) $entityId : null,
            'details' => $details,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
            'created_at' => now(),
        ]);
    }
}

