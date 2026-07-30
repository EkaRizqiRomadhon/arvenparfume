<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Log;

class AuthService
{
    /**
     * Catat aktivitas ke activity_logs. Kegagalan tidak menghentikan
     * alur autentikasi utama.
     */
    public function logActivity(int $userId, string $action, string $description, string $ipAddress): void
    {
        try {
            ActivityLog::create([
                'user_id'     => $userId,
                'action'      => $action,
                'description' => $description,
                'ip_address'  => $ipAddress,
                'created_at'  => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('AuthService: gagal menulis activity log.', [
                'error'   => $e->getMessage(),
                'user_id' => $userId,
                'action'  => $action,
            ]);
        }
    }
}
